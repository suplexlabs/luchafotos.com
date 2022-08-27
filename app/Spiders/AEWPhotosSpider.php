<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\ParseResult;

class AEWPhotosSpider extends AbstractSourceSpider
{
    public array $startUrls = [
        'https://www.allelitewrestling.com/blog/categories/photos'
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
        // todo...
    }
}
