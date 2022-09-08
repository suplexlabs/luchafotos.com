<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $source;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $source)
    {
        $this->data = $data;
        $this->source = $source;
    }

    public function handle()
    {
        /** @var \App\Datas\ImageData $info */
        $data = $this->data;
        $source = $this->source;

        if (!$source) {
            return;
        }
        if ($source->trashed()) {
            return;
        }

        $url = $data->url;
        $headers = get_headers($url, true);
        $publishDate = Carbon::parse($headers['Date']);

        $etag = data_get($headers, 'ETag', md5($url));
        list($width, $height) = getimagesize($url);

        $imageExists = $source->images()->where('etag', $etag)->exists();
        if ($imageExists) {
            return;
        }

        $site = Site::updateOrCreate(['domain' => $data->domain]);

        Image::create([
            'source_id'    => $source->id,
            'site_id'      => $site->id,
            'url'          => $data->url,
            'page_url'     => $data->pageUrl,
            'title'        => $data->title,
            'etag'         => $etag,
            'height'       => $height,
            'width'        => $width,
            'published_at' => $publishDate
        ]);

        // create smaller versions to use for search results
    }
}
