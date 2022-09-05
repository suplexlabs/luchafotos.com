<?php

namespace App\Spiders;

use App\Spiders\Middleware\ExecuteJavascriptMiddleware;
use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Downloader\Middleware\UserAgentMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;

class JavascriptSpider extends BasicSpider
{
    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
        [
            UserAgentMiddleware::class,
            [
                'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36'
            ]
        ],
    ];
    public array $spiderMiddleware = [];
    public array $itemProcessors = [];
    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class
    ];
    public int $concurrency = 2;
    public int $requestDelay = 1;

    public function __construct()
    {
        if (config('app.env') == 'local') {
            $this->downloaderMiddleware[] = [
                ExecuteJavascriptMiddleware::class,
                [
                    'wsEndpoint' => 'ws://chrome:3000',
                ]
            ];
        }

        parent::__construct();
    }

    public function parse(Response $response): Generator
    {
        // include archives
        // example: https://www.wwe.com/shows/wwenxt/archive
    }
}
