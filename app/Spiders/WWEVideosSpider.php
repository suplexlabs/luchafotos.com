<?php

namespace App\Spiders;

use App\Spiders\Traits\HasSource;
use Generator;
use App\Datas\ImageData;
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
        
        if ($data) {
            $this->dispatchJob($data, $source);
        }

        yield $this->item($data->toArray());
    }

    protected function getImageData(Response $response): ImageData|null
    {
        $pageUrl = $response->getUri();
        $components = parse_url($pageUrl);
        $domain = $components['host'];

        $title = $response->filter('meta[property="og:title"]')->attr('content');

        // get video artwork
        try {   
            $poster = $response->filter('.wwe-videobox--videoarea .vjs-poster')->first();
            preg_match('/url\("?(.+?)"?\)/', $poster->attr('style'), $matches);
            $url = $matches[1];
        }
        catch (\Exception $e) {
            return null
        }
        
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
