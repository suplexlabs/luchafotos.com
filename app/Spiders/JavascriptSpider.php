<?php

namespace App\Spiders;

use App\Datas\ImageData;
use App\Spiders\Middleware\ExecuteJavascriptMiddleware;
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
                'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36'
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
        $options = [
            'chromiumArguments' => []
        ];

        if (config('app.env') == 'local') {
            $options['wsEndpoint'] = 'ws://chrome:3000';
        }

        $this->downloaderMiddleware[] = [
            ExecuteJavascriptMiddleware::class,
            $options
        ];

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
            $poster = $image->getNode()->getAttribute('data-srcset');
            $url = explode(' ', $poster)[0];
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
