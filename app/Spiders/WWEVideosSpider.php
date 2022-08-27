<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\ExecuteJavascriptMiddleware;
use RoachPHP\Http\Response;

class WWEVideosSpider extends AbstractSourceSpider
{
    public array $startUrls = [
        'https://www.wwe.com/videos'
    ];

    public function __construct()
    {
        if (config('app.env') == 'production') {
            $this->downloaderMiddleware[] = ExecuteJavascriptMiddleware::class;
        }

        parent::__construct();
    }

    public function parse(Response $response): Generator
    {
        $anchors = $response->filter('.card-content-align-top a')->links();

        foreach ($anchors as $anchor) {
            yield $this->request('GET', $anchor->getUri(), 'parseArticlePage');
        }
    }

    public function parseArticlePage(Response $response): Generator
    {
        $source = $this->getSource();
        $info = $this->getLinkInfo($response);

        if (empty($info)) {
            yield $this->item([]);
            return;
        }

        $found = $source->links()->where('guid', $info->guid)->first();
        if ($found && $found->media()->exists()) {
            yield $this->item([]);
            return;
        }

        $this->dispatchJob($info, $source);

        yield $this->item($info->toArray());
    }
}
