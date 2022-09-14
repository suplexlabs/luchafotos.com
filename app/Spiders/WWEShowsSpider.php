<?php

namespace App\Spiders;

use App\Spiders\Traits\HasSource;
use Generator;
use App\Datas\ImageData;
use RoachPHP\Http\Response;
use Symfony\Component\DomCrawler\Image;

class WWEShowsSpider extends JavascriptSpider
{
    use HasSource;

    public array $startUrls = [
        'https://www.wwe.com/shows'
    ];

    public function parse(Response $response): Generator
    {
        $anchors = $response->filter('.wwe-shows-hub--show')->links();
        foreach ($anchors as $anchor) {
            yield $this->request('GET', $anchor->getUri(), 'parseShowPage');
        }
    }

    public function parseShowPage(Response $response): Generator
    {
        $anchors = $response->filter('.show-contextual__speech-bubble.results .show-contextual__logo a')->links();
        foreach ($anchors as $anchor) {
            yield $this->request('GET', $anchor->getUri(), 'parseResultPage');
        }
    }

    public function parseResultPage(Response $response): Generator
    {
        $source = $this->getSource();

        $images = $response->filter('.episode-feed-card--primary-img img')->images();
        foreach ($images as $image) {
            $data = $this->getImageData($response, $image);
            dd($data);

            $found = $source->images()->where('url', $data->url)->first();
            if ($found) {
                yield $this->item([]);
                return;
            }

            $this->dispatchJob($data, $source);

            yield $this->item($data->toArray());
        }
    }

    protected function getImageData(Response $response, Image $image): ImageData|null
    {
        $pageUrl = $response->getUri();
        $components = parse_url($pageUrl);
        $domain = $components['host'];

        $title = $image->getNode()->getAttribute('alt');
        $poster = $image->getNode()->getAttribute('data-srcset');
        $url = explode(' ', $poster)[0];

        if (substr($url, 0, 1) == '/') {
            $url = 'https://' . $domain . $url;
        }

        $info = ImageData::from([
            'title'   => $title,
            'url'     => $url,
            'pageUrl' => $pageUrl,
            'domain'  => $domain
        ]);

        return $info;
    }
}
