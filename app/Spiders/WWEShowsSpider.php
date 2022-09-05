<?php

namespace App\Spiders;

use App\Spiders\Traits\HasSource;
use Generator;
use RoachPHP\Http\Response;

class WWEShowsSpider extends JavascriptSpider
{
    use HasSource;

    public array $startUrls = [
        'https://www.wwe.com/shows'
    ];

    public function parse(Response $response): Generator
    {
        // include archives
        // example: https://www.wwe.com/shows/wwenxt/archive
    }
}
