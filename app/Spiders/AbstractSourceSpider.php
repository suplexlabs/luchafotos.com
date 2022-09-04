<?php

namespace App\Spiders;

use App\Datas\LinkInfo;
use App\Enums\Sources;
use App\Jobs\SaveLink;
use App\Models\Source;
use Carbon\Carbon;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Downloader\Middleware\RobotsTxtMiddleware;
use RoachPHP\Downloader\Middleware\UserAgentMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Http\Response;

abstract class AbstractSourceSpider extends BasicSpider
{
    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
        [
            UserAgentMiddleware::class,
            [
                'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36'
            ]
        ],
        // RobotsTxtMiddleware::class
    ];
    public array $spiderMiddleware = [];
    public array $itemProcessors = [];
    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class
    ];
    public int $concurrency = 1;
    public int $requestDelay = 1;

    protected function getSource(): Source
    {
        $source = Source::where('type', Sources::CRAWLER)
            ->where('is_active', true)
            ->where('site', $this->startUrls[0])
            ->first();

        if (!$source) {
            $source = Source::create([
                'name'      => explode("\\", get_class($this))[0],
                'type'      => Sources::CRAWLER,
                'is_active' => true,
                'site'      => $this->startUrls[0]
            ]);
        }

        return $source;
    }

    protected function getLinkInfo(Response $response): LinkInfo|null
    {
        $url = $response->getUri();
        $title = $response->filter('meta[property="og:title"]')->attr('content');

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
            'title'      => $title,
            'url'        => $url,
            'publishAt'  => $publishDate
        ]);

        return $info;
    }

    protected function dispatchJob(LinkInfo $info, Source $source)
    {
        dispatch(new SaveLink($info, $source))
            ->onQueue('default');
    }
}
