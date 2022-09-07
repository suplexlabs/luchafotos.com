<?php

namespace App\Jobs;

use App\Models\Image;
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

        $imageExists = $source->images()->where('etag', $data->etag)->exists();
        if ($imageExists) {
            return;
        }

        Image::create([
            'source_id'    => $source->id,
            'url'          => $data->url,
            'domain'       => $data->domain,
            'title'        => $data->title,
            'etag'         => $data->etag,
            'height'       => $data->height,
            'width'        => $data->width,
            'published_at' => $data->publishedAt
        ]);

        // create smaller versions to use for search results
    }
}
