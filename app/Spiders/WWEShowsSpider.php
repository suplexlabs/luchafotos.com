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

            try {
                $this->dispatchJob($data, $source);
            } catch (\Exception $e) {
                dd($data, $e);
            }

            yield $this->item($data->toArray());
        }
    }

    public function parseResultPage(Response $response): Generator
    {
        $source = $this->getSource();

        /** @var \DOMElement[] $cards */
        $response->filter('.episode-feed-cards .episode-feed-card')
            ->each(function ($card) use ($source, $response) {
                try {
                    $image = $card->filter('.episode-feed-card--primary-img img')->image();
                } catch (\Exception $e) {
                    return;
                }

                $data = $this->getImageDataByImage($response, $image);

                $data->title = $card->filter('.episode-feed-card--title')->text();
                $data->pageTitle = $image->getNode()->getAttribute('title');

                $this->dispatchJob($data, $source);
            });

        yield $this->item([]);
    }
}
