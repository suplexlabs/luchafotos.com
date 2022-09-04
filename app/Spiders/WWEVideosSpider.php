<?php

namespace App\Spiders;

use Generator;
use App\Spiders\Middlewares\ExecuteJavascriptMiddleware;
use RoachPHP\Http\Response;

class WWEVideosSpider extends AbstractSourceSpider
{
    public array $startUrls = [
        'https://www.wwe.com/videos',
    ];

    public function __construct()
    {
        if (config('app.env') == 'local') {
            $this->downloaderMiddleware[] = [
                ExecuteJavascriptMiddleware::class,
                [
                    'wsEndpoint' => 'ws://chrome:3000',
                ]
            ];
        }

        parent::__construct();
    }

    public function parse(Response $response): Generator
    {
        $anchors = $response->filter('.landing-page--feed-card .card-content-align-top a')->links();

        foreach ($anchors as $anchor) {
            dd($anchor->getUri());
            yield $this->request('GET', $anchor->getUri(), 'parsePage');
        }
    }

    public function parsePage(Response $response): Generator
    {
        $source = $this->getSource();
        $info = $this->getLinkInfo($response);

        if (empty($info)) {
            yield $this->item([]);
            return;
        }

        $poster = $response->filter('#wwe-videobox--videoarea .vjs-poster')->first();
        $imagePath = $poster->attr('style');

        dd($imagePath);

        $info->imagePath  = $imagePath;
        $info->imageTitle = $info->title;

        $found = $source->links()->where('url', $info->url)->first();
        if ($found) {
            yield $this->item([]);
            return;
        }

        $this->dispatchJob($info, $source);

        yield $this->item($info->toArray());
    }
}
