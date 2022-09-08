<?php

namespace App\Datas;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class ImageData extends Data
{
    public function __construct(
        public string $title,
        public string $url,
        public string $domain,
        public string $pageUrl,
    ) {
    }
}
