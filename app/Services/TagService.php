<?php

namespace App\Services;

use App\Enums\Companies;
use App\Enums\Types;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService
{
    public function createTagsByImage(Image $image): Collection
    {
        $tags = collect([
            $this->createCompanyTag($image),
            $this->createEventTag($image),
            $this->createWrestlerTag($image)
        ])
            ->flatten()
            ->filter(fn ($tag) => $tag->name);

        return $tags;
    }

    public function createCompanyTag(Image $image): Collection
    {
        $tags = collect([]);
        $domain = $image->site->domain;

        $companies = Companies::cases();
        foreach ($companies as $company) {
            if (stripos($domain, $company->value)) {
                $tag = Tag::updateOrCreate([
                    'name' => $company,
                    'code' => str($company->value)->slug(),
                    'type' => Types::COMPANY
                ]);
                $tags->push($tag);
                break;
            }
        }

        return $tags;
    }

    public function createEventTag(Image $image): Collection
    {
        $tags = collect([]);
        return $tags;
    }

    public function createMatchTag(Image $image): Collection
    {
        $tags = collect([]);
        return $tags;

        // check the title for wrestler name
        if (stripos($image->title, ' vs. ')) {
            $names = str($image->title)->explode(' vs. ');
            $name = count($names) == 2 ? $names[0] : 0;

            if ($name) {
                $tag = Tag::updateOrCreate([
                    'name' => $name,
                    'code' => str($name)->slug(),
                    'type' => Types::WRESTLER
                ]);
                $tag->push($tag);
            }
        }

        return $tags;
    }

    public function createWrestlerTag(Image $image): Collection
    {
        $tags = collect([]);
        $title = $image->title;

        preg_match_all('/(.+?).(vs.|&|:|-|–)/', $title, $matches);

        if (
            !preg_match('/[,]/', $title)
            && count($matches) >= 3
            && count($matches[0]) > 1
        ) {
            $names = $matches[1];
            array_pop($names);

            foreach ($names as $name) {
                $tag = Tag::updateOrCreate([
                    'name' => $name,
                    'code' => str($name)->slug(),
                    'type' => Types::WRESTLER
                ]);
                $tags->push($tag);
            }
        }

        return $tags;
    }
}
