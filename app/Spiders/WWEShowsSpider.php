<?php

namespace App\Spiders;

use App\Spiders\Traits\HasSource;
use Generator;
use RoachPHP\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

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

        $anchors = $response->filter('.wwe-feed-card--thumb.icon-gallery')->links();
        foreach ($anchors as $anchor) {
            yield $this->request('GET', $anchor->getUri(), 'parseGalleryPage');
        }
    }

    public function parseGalleryPage(Response $response): Generator
    {
        $source = $this->getSource();
        $images = $response->filter('.wwe-gallery--item img')->images();

        foreach ($images as $image) {
            $data = $this->getImageDataByImage($response, $image);
            $this->dispatchJob($data, $source);

            yield $this->item($data->toArray());
        }
    }

    public function parseResultPage(Response $response): Generator
    {
        $source = $this->getSource();

        /** @var \DOMElement[] $cards */
        $cards = $response->filter('.episode-feed-cards .episode-feed-card');
        foreach ($cards as $card) {
            dd($card);

            $card = new Crawler($card);

            dd($card->filter('.episode-feed-card--primary-img img')->image());

            $image = $card->filter('.episode-feed-card--primary-img img')->image();

            $data = $this->getImageDataByImage($response, $image);

            $data->title = $card->filter('.episode-feed-card--title')->text();
            $data->pageTitle = $image->getNode()->getAttribute('title');

            dd($data);

            $this->dispatchJob($data, $source);

            yield $this->item([]);
        }
    }
}
