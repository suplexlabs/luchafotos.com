<?php

namespace App\Datas;

use FeedIo\Feed;
use Spatie\LaravelData\Data;

class LookupResult extends Data
{
    public function __construct(
        public string $rss,
        public Feed $feed
    ) {
    }
}
