<?php

namespace App\Console\Commands;

use App\Datas\AudioInfo;
use App\Datas\LinkInfo;
use App\Enums\Links;
use App\Enums\Regexes;
use App\Jobs\SaveLink;
use App\Models\Link;
use App\Repositories\SourceRepository;
use App\Services\RssService;
use Carbon\Carbon;
use Goose\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Log;

class FetchRssSources extends Command
{
    protected $signature = 'fetch:rss-sources {typeOrId}';
    protected $description = 'Fetch sources with rss feeds and save their links into database';

    private SourceRepository $sources;
    private RssService $rss;

    public function __construct()
    {
        parent::__construct();

        $this->sources = app(SourceRepository::class);
        $this->rss = app(RssService::class);
    }

    public function handle()
    {
        $typeOrId = $this->argument('typeOrId');

        // get active sources by type
        $this->sources->getRssSources($typeOrId)->chunkById(200, function ($sources) {
            $sources->load('links');

            /** @var \App\Models\Source[] $sources */
            foreach ($sources as $source) {
                $lastItem = null;
                $numLinksSaved = 0;
                $existingLinks = $source->links;

                try {
                    /** @var \FeedIo\FeedInterface $feed */
                    $feed = $this->rss->load($source->rss);
                } catch (\FeedIo\Reader\ReadErrorException $e) {
                    Log::info("Read Error for source {$source->name}. {$e->getMessage()}");

                    if ($existingLinks->isEmpty()) {
                        $source->delete();
                    }
                    continue;
                } catch (\Exception $e) {
                    Log::error("Unable to load source {$source->name}. {$e->getMessage()}");
                    continue;
                }

                $this->info("Loading source {$source->name}.");
                foreach ($feed as $item) {
                    /** @var \FeedIo\Feed\Item $item */
                    if (!$lastItem || $item->getLastModified() > $lastItem->getLastModified()) {
                        $lastItem = $item;
                    }

                    $payload = [
                        'title'       => $item->getTitle(),
                        'guid'        => $item->getPublicId(),
                        'publishDate' => Carbon::parse($item->getLastModified()),
                        'url'         => $item->getLink()
                    ];

                    // skip blog links if we don't need it
                    if ($source->isBlog()) {
                        $media = $item->getMedias()->current();
                        if ($media && str_contains($media->getType(), 'audio')) {
                            continue;
                        }

                        if (
                            !$source->is_official
                            && preg_match(Regexes::IGNORE_REGEX->value, $payload['title'])
                        ) {
                            continue;
                        }
                    }

                    if (empty($payload['content']) && $item->getContent()) {
                        $payload['content'] = $item->getContent();
                    }

                    if ($source->isPodcast()) {
                        /** @var \FeedIo\Feed\Item\Media $audio */
                        $audio = $item->getMedias()->current();
                        if (empty($audio)) {
                            continue;
                        }

                        /** @var \FeedIo\Feed\Node\Element $itunesImage */
                        $itunesImage = collect($item->getElementIterator('itunes:image'))->first();
                        if (empty($itunesImage)) {
                            $itunesImage = collect($feed->getElementIterator('itunes:image'))->first();
                        }

                        $explicit = collect($item->getElementIterator('itunes:explicit'))->first();
                        $duration = collect($item->getElementIterator('itunes:duration'))->first();
                        $duration = $duration ? $duration->getValue() : 0;

                        if (!is_numeric($duration)) {
                            $duration = $this->timeToSeconds($duration);
                        }

                        $audioInfo = AudioInfo::from([
                            'url'        => $audio->getUrl(),
                            'duration'   => (int) $duration,
                            'isExplicit' => $explicit ? $explicit->getValue() == 'Yes' : false,
                            'image'      => $itunesImage ? $itunesImage->getAttribute('href') : $feed->getLogo()
                        ]);

                        if (empty($payload['url'])) {
                            $payload['url'] = $audioInfo->url;
                        }
                        $payload['audio'] = $audioInfo;
                    }

                    if (empty($payload['guid'])) {
                        $payload['guid'] = $payload['url'];
                    }
                    $info = LinkInfo::from($payload);

                    if ($source->isVideo()) {
                        $info->url = str_replace('watch?v=', 'embed/', $info->url);
                        $info->url = preg_replace('/\?.+$/', "", $info->url);
                    }

                    $existing = $existingLinks->where('guid', $info->guid)->first();
                    if (!$existing) {
                        $existing = $existingLinks->where('url', $info->url)->first();
                    }

                    // remove video if it no longer exists
                    if (
                        $existing
                        && $source->isVideo()
                        && !$existing->doesVideoExists()
                    ) {
                        $existing->delete();
                        continue;
                    }

                    // TODO: Review this a bit more before we use it
                    // if ($source->isBlog() && !$source->is_official) {
                    //     $client = new Client();
                    //     $article = $client->extractContent($info->url);
                    //     $urls = collect($article->getLinks())->pluck('url')->map(function ($url) {
                    //         $service = app(RssService::class);
                    //         return $service->getFinalUrl($url);
                    //     });

                    //     $skipLink = Link::whereIn('url', $urls->toArray())
                    //         ->where('type', Links::ARTICLE)
                    //         ->where('publish_date', '>=', now()->subHours(24))
                    //         ->where('source_id', '!=', $source->id)
                    //         ->whereHas('source', function ($query) {
                    //             $query->where('is_official', false);
                    //         })
                    //         ->exists();

                    //     if ($skipLink) {
                    //         if ($existing) {
                    //             $existing->is_active = false;
                    //             $existing->save();
                    //         }
                    //         continue;
                    //     }
                    // }

                    if (
                        !$source->needs_to_be_imported
                        && $existing
                        && (!$source->isVideo() && $existing->media()->exists())
                    ) {
                        continue;
                    }

                    $this->info("Dispatching job to save link \"{$info->title}\" for \"{$source->name}\".");
                    dispatch(new SaveLink($info, $source))
                        ->onQueue($source->isPodcast() ? 'podcast' : 'default');
                    $numLinksSaved++;
                }

                $intervals = $this->rss->intervals($lastItem);
                $isActive = $source->links()->exists();

                $source->update([
                    'needs_to_imported'            => !$isActive,
                    'is_active'                    => $isActive,
                    'last_check_date'              => $intervals->lastCheckDate,
                    'next_check_date'              => $intervals->nextCheckDate,
                    'minutes_to_check_for_updates' => $intervals->minutesToCheckForUpates
                ]);
            }
        });
    }

    private function timeToSeconds(string $time): int
    {
        if (empty($time)) {
            return 0;
        }

        $arr = explode(':', $time);
        if (count($arr) == 3) {
            return ((int) $arr[0]) * 3600 + ((int) $arr[1]) * 60 + ((int) $arr[2]);
        } else if (count($arr) == 2) {
            return ((int) $arr[0]) * 60 + ((int) $arr[1]);
        } else {
            return 0;
        }
    }
}
