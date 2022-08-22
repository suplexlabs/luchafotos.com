<?php

namespace App\Datas;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class RssIntervals extends Data
{
    public function __construct(
        public Carbon $lastCheckDate,
        public Carbon $nextCheckDate,
        public int $minutesToCheckForUpates
    ) {
    }
}
