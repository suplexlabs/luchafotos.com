<?php

namespace App\Spiders;

use App\Spiders\Traits\HasSource;
use Generator;
use RoachPHP\Http\Response;

class WWEVideosSpider extends JavascriptSpider
{
    use HasSource;

    public array $startUrls = [
        'https://www.wwe.com/videos',
    ];

    public function parse(Response $response): Generator
    {
        $anchors = $response->filter('.landing-page--feed-card .card-content-align-top a')->links();

        foreach ($anchors as $anchor) {
            yield $this->request('GET', $anchor->getUri(), 'parsePage');
        }
    }

    public function parsePage(Response $response): Generator
    {
        $source = $this->getSource();
        $data = $this->getImageData($response);

        if (empty($data)) {
            yield $this->item([]);
            return;
        }

        $poster = $response->filter('#wwe-videobox--videoarea .vjs-poster')->first();
        $imagePath = $poster->attr('style');

        dd($imagePath);

        $data->imagePath  = $imagePath;
        $data->imageTitle = $data->title;

        $found = $source->links()->where('url', $data->url)->first();
        if ($found) {
            yield $this->item([]);
            return;
        }

        $this->dispatchJob($data, $source);

        yield $this->item($data->toArray());
    }
}
