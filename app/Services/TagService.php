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
        $companies = Companies::cases();

        foreach ($companies as $company) {
            if ($image->site->isCompany($company)) {
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

    public function createWrestlerTag(Image $image): Collection
    {
        $tags = collect([]);
        $site = $image->site;
        $title = $image->title;
        $pattern = '/(vs\.?|&|:|-|–|,)/';

        if ($site->isCompany(Companies::IMPACT) && str($image->url)->contains('vs')) {
            $title = str(basename($image->url))
                ->explode('.')
                ->first();
            $title = str($title)->match('/(_.+?_vs_.+?-)/')
                ->snake()
                ->replace('_', ' ')
                ->squish();
        } else {
            // remove any parts we don't want
            $title = trim(preg_replace('/(\(.+\)|\w+\.? \d{1,2}, \d{2,4})/', '', $title));
        }

        // first breakup text based on top level characters
        $parts = collect(preg_split('/(:|—|-|–|,)/', $title))
            ->map(fn ($str) => trim($str));

        if ($site->isCompany(Companies::WWE)) {
            $parts = $parts->filter(function ($str) use ($site, $pattern) {
                return preg_match_all($pattern, $str);
            });
        } else if ($parts->count() > 1 && $site->isCompany(Companies::IMPACT)) {
            $parts = collect([$parts->first()]);
        } else {
            $parts = collect([]);
        }

        foreach ($parts as $part) {
            $names = collect(preg_split($pattern, $part))
                ->map(fn ($str) => trim($str))
                ->filter(fn ($str) => strlen($str));

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
