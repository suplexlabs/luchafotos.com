<?php

namespace App\Services;

use App\Enums\Companies;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService
{
    public function createTagsByImage(Image $image): Collection
    {
        $tags = collect([]);

        $tag = $this->createCompanyTag($image);
        if ($tag) {
            $tags->push($tag);
        }
        $tag = $this->createEventTag($image);
        if ($tag) {
            $tags->push($tag);
        }
        $tag = $this->createCompanyTag($image);
        if ($tag) {
            $tags->push($tag);
        }
        $tag = $this->createWrestlerTag($image);
        if ($tag) {
            $tags->push($tag);
        }

        return $tags;
    }

    public function createCompanyTag(Image $image): Tag|null
    {
        $tag = null;
        $domain = $image->site->domain;

        $companies = Companies::cases();
        foreach ($companies as $company) {
            if (stripos($domain, $company->value)) {
                $tag = Tag::updateOrCreate([
                    'name' => $company,
                    'code' => str($company)->slug()
                ]);
                break;
            }
        }

        return $tag;
    }

    public function createEventTag(Image $image): Tag|null
    {
        $tag = null;

        return $tag;
    }

    public function createWrestlerTag(Image $image): Tag|null
    {
        $tag = null;

        // check the title for wrestler name
        if (stripos($image->title, ' - ')) {
            $names = str($image->title)->explode(' - ');
            $name = count($names) == 2 ? $names[0] : 0;

            if ($name) {
                $tag = Tag::updateOrCreate([
                    'name' => $name,
                    'code' => str($name)->slug()
                ]);
            }
        }

        return $tag;
    }
}
