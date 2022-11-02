<?php

namespace App\Repositories;

use App\Datas\ImageData;
use App\Models\Image;
use App\Models\Page;
use App\Models\Site;
use App\Models\Source;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image as FacadesImage;

class ImageRepository extends BaseRepository
{
    public function model()
    {
        return Image::class;
    }

    public function createByData(Source $source, ImageData $data): Image|null
    {
        $url = $data->url;
        try {
            $img = FacadesImage::make($url);
        } catch (NotReadableException $e) {
            // if the image is not reaable then skip it
            return null;
        }

        $headers = get_headers($url, true);
        $publishDate = Carbon::parse($headers['Date']);

        $etag = data_get($headers, 'ETag', md5($url));
        $etag = str($etag)->replace('"', '');

        $md5 = md5_file($url);

        $imageExists = $source->images()
            ->where(function ($query) use ($etag, $md5) {
                $query->where('etag', $etag)
                    ->orWhere('md5', $md5);
            })
            ->exists();
        if ($imageExists) {
            return null;
        }

        $site = Site::updateOrCreate(['domain' => $data->domain]);
        $page = Page::updateOrCreate([
            'site_id' => $site->id,
            'url'     => $data->pageUrl,
            'title'   => $data->pageTitle ?: $data->title
        ]);

        // make sure videos only have one image
        $wweVideosPageId = 1;
        if ($source->id == $wweVideosPageId && $page->images()->count() > 0) {
            $page->images()->forceDelete();
        }

        return Image::create([
            'source_id'    => $source->id,
            'site_id'      => $site->id,
            'page_id'      => $page->id,
            'url'          => $url,
            'title'        => $data->title,
            'etag'         => $etag,
            'md5'          => $md5,
            'height'       => $img->height(),
            'width'        => $img->width(),
            'published_at' => $publishDate
        ]);
    }

    /**
     * @param Tag $tag
     * @return Collection[]|Image[]
     */
    public function getByTag(Tag $tag): Collection
    {
        $images = $this->model->search($tag->name)
            ->orderBy('published_at', 'desc')
            ->take(50)
            ->get()
            ->load(['site', 'page']);

        return $images;
    }

    public function getRecent(): Collection
    {
        $images = $this->model
            ->orderBy('published_at', 'desc')
            ->take(15)
            ->get()
            ->load(['site', 'page']);

        return $images;
    }
}
