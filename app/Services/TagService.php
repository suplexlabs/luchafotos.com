<?php

namespace App\Services;

use App\Enums\Companies;
use App\Enums\Types;
use App\Models\Image;
use App\Models\Site;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService
{
    public function createTagsByImage(Image $image): Collection
    {
        $tags = collect([
            $this->createCompanyTag($image),
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

        $image->load(['site']);
        
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

    public function createWrestlerTag(Image $image): Collection
    {
        $tags = collect();
        $site = $image->site;
        $pattern = '/(vs\.?|&|:|-|–|,)/';

        if ($site->isCompany(Companies::WWE)) {
            $parts = $this->createWrestlerTagForWWE($image, $pattern, $site);
        } else if ($site->isCompany(Companies::IMPACT)) {
            $parts = $this->createWrestlerTagForImpact($image, $pattern, $site);
        }

        foreach ($parts as $part) {
            $names = collect(preg_split($pattern, (string) $part))
                ->map(fn ($str) => trim($str))
                ->filter(function ($str) {
                    $words = explode(' ', $str);
                    return (count($words) > 0 && count($words) < 4);
                });

            foreach ($names as $name) {
                // don't create any tags more than
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

    public function createWrestlerTagForWWE(Image $image, string $tagPattern, Site $site): Collection
    {
        $title = $image->title;

        // remove any content we don't care about
        $title = trim(preg_replace('/(\(.+\)|\w+\.? \d{1,2}, \d{2,4})/', '', $title));

        // split up title into smaller parts and filter out anything that's not tag worthy
        $parts = collect(preg_split('/(:|—|-|–|,)/', $title))
            ->map(fn ($str) => trim($str))
            ->filter(function ($str) use ($tagPattern) {
                return preg_match_all($tagPattern, $str);
            });

        return $parts;
    }

    public function createWrestlerTagForImpact(Image $image, string $tagPattern, Site $site): Collection
    {
        $title = $image->title;

        // Disable for now since it's not reliable per image
        // if (str($image->url)->contains(['_vs_', '-v-'])) {
        //     $title = str(basename($image->url))
        //         ->explode('.')
        //         ->first();
        //     $title = str($title)
        //         ->match('/(_.+?_vs_.+?-|_.+?-v-.+?-)/')
        //         ->snake()
        //         ->replace('_', ' ')
        //         ->squish();
        // }

        $parts = collect(preg_split('/(:|—|-|–|,)/', $title))
            ->map(fn ($str) => trim($str));

        if ($parts->count() > 1 && $site->isCompany(Companies::IMPACT)) {
            $parts = collect([$parts->first()]);
        }

        return $parts;
    }
}
