<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService
{
    public function createTagsByImage(Image $image): Collection
    {
    }

    public function createCompanyTag(string $value): Tag
    {
    }

    public function createEventTag(string $value): Tag
    {
    }

    public function createWrestlerTag(string $value): Tag
    {
    }
}
