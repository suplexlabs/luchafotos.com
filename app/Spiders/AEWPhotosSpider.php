<?php

namespace App\Spiders;

use App\Spiders\Traits\HasSource;
use Generator;
use RoachPHP\Http\Response;

class AEWPhotosSpider extends JavascriptSpider
{
    use HasSource;

    public array $startUrls = [
        'https://www.allelitewrestling.com/blog/categories/photos'
    ];


    public function parse(Response $response): Generator
    {
        // todo...
    }
}
