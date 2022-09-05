<?php

use Spatie\LaravelData\Data;

class ImageData extends Data
{
    public function __construct(
        public string $title,
        public string $url
    ) {
    }
}
