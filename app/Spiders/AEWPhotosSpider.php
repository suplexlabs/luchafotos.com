<?php

namespace App\Spiders;

use App\Datas\ImageData;
use App\Spiders\Traits\HasSource;
use Generator;
use RoachPHP\Http\Response;

class AEWPhotosSpider extends JavascriptSpider
{
    use HasSource;

    public array $startUrls = [
        'https://www.allelitewrestling.com/blog/categories/photos'
    ];

    public function parse(Response $response): Generator
    {
        $anchors = $response->filter('.blog-post-category-link-hashtag-hover-color .has-custom-focus')->links();

        foreach ($anchors as $anchor) {
            yield $this->request('GET', $anchor->getNode()->getAttribute('href'), 'parsePage');
        }
    }

    public function parsePage(Response $response): Generator
    {
        $source = $this->getSource();

        $images = $response->filter('.gallery-item.image-item img')->images();
        foreach ($images as $image) {
            $data = $this->getImageDataByImage($response, $image);
            $this->dispatchJob($data, $source);
        }

        yield $this->item([]);
    }
}
