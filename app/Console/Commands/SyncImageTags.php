<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Services\TagService;
use Illuminate\Console\Command;

class SyncImageTags extends Command
{
    protected $signature = 'sync:image-tags';
    protected $description = 'Adds any missing tags';

    private TagService $tags;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->tags = app(TagService::class);

        Image::doesntHave('tags')
            ->chunkById(300, function ($images) {
                /** @var \App\Models\Image[] $images */
                foreach ($images as $image) {
                    $tags = $this->tags->createTagsByImage($image);

                    if ($tags->isNotEmpty()) {
                        $image->tags()->sync($tags->pluck('id'));
                        $this->info("created {$tags->count()} tags for image {$image->id}");
                    }
                }
            });
    }
}
