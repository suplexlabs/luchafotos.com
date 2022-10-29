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

        return $this->model->search($name)
            ->take(10)
            ->orderBy('name', 'desc')
            ->get();
    }
}
