<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\Page;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image as FacadesImage;

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
        $etag = str($etag)->replace('"', '');

        $imageExists = $source->images()->where('etag', $etag)->exists();
        if ($imageExists) {
            return;
        }

        $site = Site::updateOrCreate(['domain' => $data->domain]);
        $page = Page::updateOrCreate(['site_id' => $site->id, 'url' => $data->pageUrl, 'title' => $data->title]);

        $img = FacadesImage::make($url);

        Image::create([
            'source_id'    => $source->id,
            'site_id'      => $site->id,
            'page_id'      => $page->id,
            'url'          => $data->url,
            'title'        => $data->title,
            'etag'         => $etag,
            'height'       => $img->height(),
            'width'        => $img->width(),
            'published_at' => $publishDate
        ]);

        // create smaller versions to use for search results
    }
}
