<?php

namespace App\Jobs;

use App\Datas\ImageData;
use App\Models\Source;
use App\Repositories\ImageRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ImageData $data;
    protected Source $source;
    protected ImageRepository $images;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ImageData $data, Source $source)
    {
        $this->data = $data;
        $this->source = $source;
    }

    public function handle()
    {
        $this->images = app(ImageRepository::class);

        $data = $this->data;
        $source = $this->source;

        if (!$source) {
            return;
        }

        $this->images->createByData($source, $data);
    }
}
