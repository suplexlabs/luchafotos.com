<?php

namespace App\Spiders;

use App\Datas\LinkInfo;
use App\Enums\Sources;
use App\Jobs\SaveLink;
use App\Models\Source;
use Carbon\Carbon;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Downloader\Middleware\UserAgentMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Http\Response;

abstract class AbstractSourceSpider extends BasicSpider
{
    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
        UserAgentMiddleware::class
    ];
    public array $spiderMiddleware = [];
    public array $itemProcessors = [];
    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class
    ];
    public int $concurrency = 2;
    public int $requestDelay = 1;

    protected function getSource(): Source
    {
        return Source::where('type', Sources::CRAWLER)
            ->where('is_active', true)
            ->where('site', $this->startUrls[0])
            ->first();
    }

    protected function getLinkInfo(Response $response): LinkInfo|null
    {
        $url = $response->getUri();
        $title = $response->filter('meta[property="og:title"]')->attr('content');
        
        try {
            $content = $response->filter('meta[property="og:description"]')->attr('content');
        }
        catch (\Exception $e) {
            $content = null;
        }


        try {
            $ldJson = json_decode($response->filter('[type="application/ld+json"]')->text());
            $publishDate = data_get($ldJson, 'datePublished');
        } catch (\Exception $e) {
            try {
                $publishDate = $response->filter('.byline-date')->text();
            } catch (\Exception $e) {
                return null;
            }
        }

        $publishDate = Carbon::parse($publishDate);
        if ($publishDate->hour == 0) {
            $publishDate->setHour(now()->hour);
            $publishDate->setMinute(now()->minute);
        }

        $info = LinkInfo::from([
            'title'       => $title,
            'url'         => $url,
            'guid'        => $url,
            'content'     => $content,
            'publishDate' => $publishDate,
        ]);

        return $info;
    }

    protected function dispatchJob(LinkInfo $info, Source $source)
    {
        dispatch(new SaveLink($info, $source))
            ->onQueue('default');
    }
}
