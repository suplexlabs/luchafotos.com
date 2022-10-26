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

    public function getSimilar($term): Collection
    {
        return $this->model->search($term)
            ->take(10)
            ->orderBy('name')
            ->get();
    }
}
