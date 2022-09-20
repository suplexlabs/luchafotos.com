<?php

namespace App\Spiders\Traits;

use App\Enums\Sources;
use App\Jobs\SaveImage;
use App\Models\Source;
use App\Datas\ImageData;

trait HasSource
{
    protected function getSource(): Source
    {
        $source = Source::where('type', Sources::CRAWLER)
            ->where('site', $this->startUrls[0])
            ->first();

        if (!$source) {
            $source = Source::create([
                'name'      => explode("\\", get_class($this))[0],
                'type'      => Sources::CRAWLER,
                'site'      => $this->startUrls[0]
            ]);
        }

        return $source;
    }

    protected function dispatchJob(ImageData $data, Source $source)
    {
        $found = $source->images()->where('url', $data->url)->first();
        if ($found) {
            return false;
        }

        dispatch(new SaveImage($data, $source));
    }
}
