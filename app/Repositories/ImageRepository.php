<?php

namespace App\Repositories;

use App\Datas\ImageData;
use App\Models\Image;
use App\Models\Page;
use App\Models\Site;
use App\Models\Source;
use Carbon\Carbon;
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

        $imageExists = $source->images()->where('etag', $etag)->exists();
        if ($imageExists) {
            return null;
        }

        $site = Site::updateOrCreate(['domain' => $data->domain]);
        $page = Page::updateOrCreate([
            'site_id' => $site->id,
            'url'     => $data->pageUrl,
            'title'   => $data->pageTitle ?: $data->title
        ]);

        return Image::create([
            'source_id'    => $source->id,
            'site_id'      => $site->id,
            'page_id'      => $page->id,
            'url'          => $url,
            'title'        => $data->title,
            'etag'         => $etag,
            'height'       => $img->height(),
            'width'        => $img->width(),
            'published_at' => $publishDate
        ]);
    }
}
