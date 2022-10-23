<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Collection;

class SearchService
{
    public function perform(string $term): Collection
    {
        $images = Image::search($term)
            ->take(100)
            ->orderBy('publish_at')
            ->get()
            ->load([
                'page' => function ($query) {
                    $query->select(['id', 'title', 'url']);
                },
                'site' => function ($query) {
                    $query->select(['id', 'domain']);
                },
                'tags' => function ($query) {
                    $query->select(['name', 'code', 'type']);
                }
            ]);

        return $images;
    }
}
