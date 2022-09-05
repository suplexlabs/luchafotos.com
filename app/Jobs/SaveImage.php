<?php

namespace App\Jobs;

use App\Enums\Sources;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class SaveImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $info;
    protected $source;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($info, $source)
    {
        $this->info = $info;
        $this->source = $source;
    }

    public function handle()
    {
        /** @var \App\Datas\LinkInfo $info */
        $info = $this->info;
        $source = $this->source;
        $linkExists = false;

        if (!$source) {
            return;
        }

        $source->refresh();
        if ($source->trashed()) {
            return;
        }

        if ($source->type == Sources::TWITTER->value) {
            // make sure we haven't already saved this url
            $linkExists = $source->links()->where('url', $info->url)->exists();
            if ($linkExists) {
                return;
            }
        } else {
            $linkExists = $source->links()->where('guid', $info->guid)->exists();
        }

        $publishDate = $info->publishDate;
        $featureUntilDate = $publishDate->copy();

        if ($source->is_official) {
            $featureUntilDate->addMinutes(10);
        }

        $link = $links->saveLink(
            $source,
            true,
            $type,
            $info->title,
            $info->url,
            $info->guid,
            $publishDate,
            $featureUntilDate,
            $info->content
        );

        $links->syncCompanies($link);

        Log::info("Saved link {$link->title}.");

        if (!$linkExists && $info->audio) {
            $audio = $info->audio;
            $links->addAudio($link, $audio->url, $audio->duration, $audio->isExplicit);
        }

        // lookup images for images
        $images = $rss->getImages($source, $this->info);
        if ($images) {
            foreach ($images as $url) {
                if ($url) {
                    $links->addImage($link, $url);
                }
            }
        }

        // associate topics to link
        if ($source->isBlog() && $link->content && !$link->topics()->exists()) {
            $entities = $nlp->getEntities($link->content);
            $entities->map(function ($entity) use ($link, $links) {
                $links->addTopic($link, $entity);
            });
        }
    }
}
