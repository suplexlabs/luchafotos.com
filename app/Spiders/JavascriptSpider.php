<?php

namespace App\Spiders;

use App\Datas\ImageData;
use App\Spiders\Middleware\BrowserlessMiddleware;
use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Downloader\Middleware\UserAgentMiddleware;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use Symfony\Component\DomCrawler\Image;

class JavascriptSpider extends BasicSpider
{
    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
        [
            UserAgentMiddleware::class,
            [
                'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36'
            ]
        ],
    ];
    public array $spiderMiddleware = [];
    public array $itemProcessors = [];
    public array $extensions = [];
    public int $concurrency = 2;
    public int $requestDelay = 1;

    public function __construct()
    {
        $this->downloaderMiddleware[] = BrowserlessMiddleware::class;

        parent::__construct();
    }

    public function parse(Response $response): Generator
    {
    }

    protected function getImageDataByImage(Response $response, Image $image): ImageData|null
    {
        $pageUrl = $response->getUri();
        $components = parse_url($pageUrl);
        $domain = $components['host'];
        $title = $image->getNode()->getAttribute('alt');

        $url = $image->getUri();
        if (!$url) {
            $url = $image->getNode()->getAttribute('data-srcset');
            $url = explode(' ', $url)[0];
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
