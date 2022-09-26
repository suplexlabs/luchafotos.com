<?php

namespace App\Spiders;

use App\Datas\ImageData;
use App\Spiders\Traits\HasSource;
use Generator;
use RoachPHP\Http\Response;

class ImpactPhotosSpider extends JavascriptSpider
{
    use HasSource;

    public array $startUrls = [
        'https://impactwrestling.com/wrestlers/'
    ];

    public function parse(Response $response): Generator
    {
        $anchors = $response->filter('a.uael-grid-gallery-img')->links();

        foreach ($anchors as $anchor) {
            yield $this->request('GET', $anchor->getUri(), 'parsePage');
        }
    }

    public function parsePage(Response $response): Generator
    {
        $source = $this->getSource();

        $anchors = $response->filter('a.elementor-gallery-item')->links();
        foreach ($anchors as $anchor) {
            $data = $this->getImageData($response, $anchor);
            $this->dispatchJob($data, $source);
        }

        yield $this->item([]);
    }

    protected function getImageData(Response $response, $anchor): ImageData
    {
        $pageUrl = $response->getUri();
        $components = parse_url($pageUrl);
        $domain = $components['host'];

        $title = $response->filter('title')->text();

        // get video artwork
        $url = $anchor->getUri();

        $info = ImageData::from([
            'title'   => $title,
            'url'     => $url,
            'pageUrl' => $pageUrl,
            'domain'  => $domain
        ]);

        return $info;
    }
}
