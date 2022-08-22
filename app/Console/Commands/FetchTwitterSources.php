<?php

namespace App\Console\Commands;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Datas\LinkInfo;
use App\Jobs\SaveLink;
use App\Repositories\SourceRepository;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Str;
use shweshi\OpenGraph\OpenGraph;

class FetchTwitterSources extends Command
{
    protected $signature = 'fetch:twitter-sources';
    protected $description = 'Fetch twitter sources and save their links into database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** @var SourceRepository $sources */
        $sources = app(SourceRepository::class);

        $sources->getTwitterSources()->chunk(100, function ($sources) {
            $sources->load('links');
            $og = new OpenGraph();

            $client = new TwitterOAuth(
                config('twitter.consumer_key'),
                config('twitter.consumer_secret'),
                config('twitter.access_token'),
                config('twitter.access_token_secret')
            );
            $client->setApiVersion('2');

            foreach ($sources as $source) {
                /** @var \App\Models\Source $source */
                $username = $source->getTwitterUsername();

                try {
                    $tweets = $client->get("users/{$username}/tweets", [
                        'max_results'  => 50,
                        'tweet.fields' => 'entities,created_at'
                    ]);
                } catch (\Abraham\TwitterOAuth\TwitterOAuthException) {
                    continue;
                }

                if (!isset($tweets->data)) {
                    continue;
                }
                $tweets = $tweets->data;

                foreach ($tweets as $tweet) {
                    if (empty($tweet->entities->urls)) {
                        continue;
                    }

                    $urls = collect($tweet->entities->urls);
                    foreach ($urls as $url) {
                        $displayUrl = data_get($url, 'unwound.url')
                            ?: data_get($url, 'unwound_url')
                            ?: data_get($url, 'expanded_url');
                        if (Str::contains($displayUrl, ['podcasts.apple.com', 'youtube', 'facebook', 'instagram', 'twitter', 'twimg.com', 'instagram', 'facebook', 'tiktok', 'showare', 'shop.njpw1972'])) {
                            continue;
                        }
                        if (!Str::contains($displayUrl, ['.com', '.net', '.org'])) {
                            continue;
                        }

                        // make sure we haven't already saved this url
                        $existing = $source->links->where('guid', $tweet->id)->first();
                        if ($existing) {
                            continue;
                        }

                        try {
                            $metas = $og->fetch($displayUrl, true);
                        } catch (\Exception) {
                            continue;
                        }

                        if (empty($metas['title'])) {
                            continue;
                        }

                        $info = LinkInfo::from([
                            'title'       => $metas['title'],
                            'url'         => $displayUrl,
                            'guid'        => $tweet->id,
                            'content'     => $tweet->text,
                            'publishDate' => Carbon::parse($tweet->created_at),
                        ]);

                        $this->info("Dispatching job to save link \"{$info->title}\" for \"{$source->name}\".");
                        dispatch(new SaveLink($info, $source))
                            ->onQueue('default');
                    }
                }
            }
        });
    }
}
