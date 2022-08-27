<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\ParseResult;

class WWEShowsSpider extends AbstractSourceSpider
{
    public array $startUrls = [
        'https://www.wwe.com/shows'
    ];

    public function __construct()
    {
        if (config('app.env') == 'production') {
            $this->downloaderMiddleware[] = ExecuteJavascriptMiddleware::class;
        }

        parent::__construct();
    }

    public function parse(Response $response): Generator
    {
        // include archives
        // example: https://www.wwe.com/shows/wwenxt/archive
    }
}
