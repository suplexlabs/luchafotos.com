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

        dd($response->filter('.gallery-item-content')->html());

        $images = $response->filter('.gallery-item.image-item img')->images();
        foreach ($images as $image) {
            $data = $this->getImageDataByImage($response, $image);
            $this->dispatchJob($data, $source);
        }

        yield $this->item([]);
    }

    protected function getImageData(Response $response): ImageData|null
    {
        $pageUrl = $response->getUri();
        $components = parse_url($pageUrl);
        $domain = $components['host'];

        $title = $response->filter('meta[property="og:title"]')->attr('content');

        // get video artwork
        $poster = $response->filter('.wwe-videobox--videoarea .vjs-poster')->first();
        preg_match('/url\("?(.+?)"?\)/', $poster->attr('style'), $matches);

        $url = $matches[1];
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
