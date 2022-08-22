<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class ComplexSpider extends AbstractSourceSpider
{
    public array $startUrls = [
        'https://www.complex.com/author/complex-sports'
    ];

    public function parse(Response $response): Generator
    {
        // todo...
    }
}
