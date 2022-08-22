<?php

namespace App\Datas;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use App\Datas\AudioInfo;

class LinkInfo extends Data
{
    public function __construct(
        public string $title,
        public string $url,
        public string $guid,
        public Carbon $publishDate,
        public ?string $content = null,
        public ?AudioInfo $audio = null
    ) {
    }
}
