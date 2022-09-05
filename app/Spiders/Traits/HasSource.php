<?php

namespace App\Spiders\Traits;

use App\Enums\Sources;
use App\Jobs\SaveImage;
use App\Models\Source;
use Carbon\Carbon;
use ImageData;
use RoachPHP\Http\Response;

trait HasSource
{
    protected function getSource(): Source
    {
        $source = Source::where('type', Sources::CRAWLER)
            ->where('is_active', true)
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

    protected function getImageData(Response $response): ImageData|null
    {
        $url = $response->getUri();
        $title = $response->filter('meta[property="og:title"]')->attr('content');

        try {
            $ldJson = json_decode($response->filter('[type="application/ld+json"]')->text());
            $publishDate = data_get($ldJson, 'datePublished');
        } catch (\Exception $e) {
            try {
                $publishDate = $response->filter('.byline-date')->text();
            } catch (\Exception $e) {
                return null;
            }
        }

        $publishDate = Carbon::parse($publishDate);
        if ($publishDate->hour == 0) {
            $publishDate->setHour(now()->hour);
            $publishDate->setMinute(now()->minute);
        }

        $info = ImageData::from([
            'title'      => $title,
            'url'        => $url,
            'publishAt'  => $publishDate
        ]);

        return $info;
    }

    protected function dispatchJob(ImageData $data, Source $source)
    {
        dispatch(new SaveImage($data, $source));
    }
}
