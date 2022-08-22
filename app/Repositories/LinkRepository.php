<?php

namespace App\Repositories;

use App\Enums\Links;
use App\Enums\Sources;
use App\Enums\Topics;
use App\Models\Company;
use App\Repositories\BaseRepository;
use App\Models\Link;
use App\Models\Source;
use App\Models\Topic;
use Carbon\Carbon;
use Diarmuidie\NiceID\NiceID;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;
use Plank\Mediable\Facades\MediaUploader;
use Str;
use Intervention\Image\Exception\NotReadableException;

/**
 * Class LinkRepository.
 *
 * @package namespace App\Repositories;
 */
class LinkRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Link::class;
    }

    public function getFeed(int $page = 0, bool $showSoilers = true, string $company = null,): Collection
    {
        $limit = 30;
        $query = $this->model
            ->where('type', Links::ARTICLE)
            ->where('is_active', true)
            ->orderBy('featured_until_date', 'desc')
            ->whereHas('source', function ($query) {
                $query->where('is_active', true);
            })
            ->limit($limit)
            ->offset($page * $limit);

        if ($company) {
            $query->byCompany($company);
        }

        if (!$showSoilers) {
            $query->noSpoilers();
        }

        return $query->with(['audio', 'source', 'media'])->get();
    }

    public function getLinks(Links $type = null, $limit = 4)
    {
        $query = $this->model
            ->where('is_active', true)
            ->orderby('featured_until_date', 'desc')
            ->limit($limit);

        if ($type) {
            $query->where('type', $type);
        }

        if ($type == Links::PODCAST) {
            $query->has('source.group');
        }

        return $query->with(['media'])->get();
    }

    public function saveLink(
        Source $source,
        bool $isActive,
        Links $type,
        string $title,
        string $url,
        string $guid,
        Carbon $publishDate,
        Carbon $featuredUntilDate,
        string $content = null,
        string $uniqueId = null
    ): Link {
        $code = Str::slug($title);
        $hasher = new NiceID($title . $publishDate->toDateString());
        $hasher->setMinLength(10);
        $uniqueId = $uniqueId ?: $hasher->encode(1);

        return $this->updateOrCreate(
            ['guid' => $guid, 'source_id' => $source->id],
            [
                'is_active'           => $isActive,
                'source_id'           => $source->id,
                'unique_id'           => $uniqueId,
                'type'                => $type,
                'title'               => $title,
                'code'                => $code,
                'url'                 => $url,
                'guid'                => $guid,
                'content'             => $content,
                'publish_date'        => $publishDate,
                'featured_until_date' => $featuredUntilDate
            ]
        );
    }

    public function addAudio(Link $link, string $url, float $duration, bool $isExplicit = false, int $episode = null, int $season = null)
    {
        if (!is_numeric($duration) || $duration < 0) {
            $duration = 0;
        }
        if (!is_numeric($episode) || $episode < 0) {
            $episode = 0;
        }
        if (!is_numeric($season) || $season < 0) {
            $season = 0;
        }

        $link->audio()->updateOrCreate(
            ['link_id' => $link->id],
            [
                'link_id'     => $link->id,
                'url'         => $url,
                'duration'    => $duration,
                'is_explicit' => $isExplicit,
                'episode'     => $episode,
                'season'      => $season
            ]
        );
    }

    public function addTopic(Link $link, string $name)
    {
        if (empty($name)) {
            return;
        }

        // check if topic exists
        $topic = Topic::where('name', 'like', "%{$name}%")->first();

        if (!$topic) {
            // Look up topic
            $topic = Topic::updateOrCreate([
                'name' => $name,
                'type' => Topics::KEYWORD
            ], [
                'name' => $name,
                'code' => Str::slug($name),
                'type' => Topics::KEYWORD
            ]);
        }

        $link->topics()->attach($topic->id);
    }

    public function addImage(Link $link, string $url)
    {
        $types = ['medium' => 500, 'thumbnail' => 100, 'original' => null];

        if (empty($url)) {
            return;
        }

        $id = $link->unique_id ?: $link->id;
        $basepath = "links/{$id}";

        foreach ($types as $type => $size) {
            try {
                $image = Image::make($url);
            } catch (NotReadableException $e) {
                continue;
            }

            $filename = "{$type}_" . rand();

            if ($size) {
                $image->resize($size, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $media = MediaUploader::fromString($image->encode())
                ->toDestination('s3', $basepath)
                ->useFilename($filename)
                ->makePublic()
                ->upload();

            $media->width = $image->getWidth();
            $media->height = $image->getHeight();
            $media->save();

            $link->syncMedia($media, $type);
        }
    }

    public function syncCompanies(Link $link)
    {
        $ids = collect([]);
        $companies = Company::all();

        foreach ($companies as $company) {
            $constant = strtoupper("{$company->code}_REGEX");
            if (defined('\App\Enums\Regexes::' . $constant)) {
                $regex = constant('\App\Enums\Regexes::' . $constant);
                if (
                    preg_match($regex->value, $link->title)
                    // || preg_match($regex->value, $link->content)
                ) {
                    $ids[] = $company->id;
                }
            } else if (str_contains($link->title, $company->abbr)) {
                $ids[] = $company->id;
            }
        }

        $link->companies()->sync(
            $ids->unique()->toArray()
        );
    }

    public function getVideoChannel(string $sourceId): Collection
    {
        return $this->model
            ->whereHas('source', function ($query) use ($sourceId) {
                $query->where('unique_id', $sourceId);
            })
            ->where('type', Sources::YOUTUBE)
            ->orderBy('publish_date', 'desc')
            ->limit(20)
            ->get();
    }
}
