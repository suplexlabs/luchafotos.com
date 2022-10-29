<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class TagRepository extends BaseRepository
{
    public function model()
    {
        return Tag::class;
    }

    public function getSimilar($name): Collection
    {
        if (empty($name)) {
            return collect();
        }

        $tags = $this->model->search($name)
            ->take(10)
            ->get()
            ->sortBy(function (Tag $tag) use ($name) {
                $tagName = $tag->name;
                $indexFound = stripos($tagName, $name);
                $indexEnd = $indexFound + strlen($name);
                $nextChar = $tagName[$indexEnd++];

                if ($nextChar != ' ') {
                    $indexFound += 10;
                }

                return $indexFound;
            })
            ->values();

        return $tags;
    }
}
