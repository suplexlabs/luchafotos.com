<?php

namespace App\Repositories;

use App\Enums\Links;
use App\Enums\Sources;
use App\Models\Group;
use App\Repositories\BaseRepository;
use App\Models\Source;
use Carbon\Carbon;
use Diarmuidie\NiceID\NiceID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Str;

/**
 * Class SourceRepository.
 *
 * @package namespace App\Repositories;
 */
class SourceRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Source::class;
    }

    public function getTwitterSources(): Builder
    {
        return $this->model
            ->where('type', Sources::TWITTER)
            ->where('is_active', true);
    }

    public function getRssSources(string|int $typeOrId): Builder
    {
        $now = Carbon::now();

        if (is_numeric($typeOrId)) {
            return $this->model->where('id', $typeOrId);
        }

        return $this->model
            ->whereNotNull('rss')
            ->where('type', $typeOrId)
            ->where(function ($query) use ($now) {
                $query
                    ->where('needs_to_be_imported', true)
                    ->orWhere(function ($query) use ($now) {
                        $query->where('is_active', true)
                            ->where('next_check_date', '<=', $now);
                    });
            })
            ->orderBy('is_official', 'desc');
    }

    public function saveSource(
        string $name,
        Sources $type,
        string $site = null,
        string $rss = null,
        string $description = null,
        bool $isActive = false,
        bool $isOfficial = false,
        bool $needsToBeImported = true,
        string $uniqueId = null
    ): Source {
        $code = Str::slug($name);
        $hasher = new NiceID($name . $type->value . $site);
        $hasher->setMinLength(10);
        $uniqueId = $uniqueId ?: $hasher->encode(1);
        $lookup = ['unique_id' => $uniqueId];

        return $this->model->withTrashed()->updateOrCreate(
            $lookup,
            [
                'name'                 => $name,
                'code'                 => $code,
                'type'                 => $type,
                'description'          => $description,
                'site'                 => $site,
                'rss'                  => $rss,
                'is_active'            => $isActive,
                'is_official'          => $isOfficial,
                'needs_to_be_imported' => $needsToBeImported,
                'unique_id'            => $uniqueId
            ]
        );
    }

    public function getList($isActive = true, $types = null, $term = null): Collection
    {
        $query = $this->model
            ->where('is_active', $isActive)
            ->where('needs_to_be_imported', false);

        if ($types) {
            $query->whereIn('type', $types);
        }

        if ($term) {
            $query->where('name', 'like', "%{$term}%");
        }

        return $query->orderBy('wrestlability', 'desc')->limit(20)->get();
    }

    public function getEpisodes(string|int $sourceId, string $term = null): Collection
    {
        /** @var \App\Models\Source */
        $source = $this->model->where('unique_id', $sourceId)->first();
        $query = $source->links();

        if ($term) {
            $query->where(function ($query) use ($term) {
                $query->where('title', 'like', "%{$term}%")
                    ->orWhere('content', 'like', "%{$term}%");
            });
        }

        return $query
            ->orderBy('publish_date', 'desc')
            ->with('audio', 'source', 'media')
            ->get();
    }

    public function getVideoGroups(): Collection
    {
        $sources = $this->model
            ->where('type', Sources::YOUTUBE)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return $sources->map(function ($source) {
            $links = $source->links()->orderBy('publish_date', 'desc')->limit(5)->get();
            $links->load('audio', 'source', 'media');

            return [
                'source' => $source,
                'links'  => $links
            ];
        });
    }

    public function getPodcastGroups(): Collection
    {
        $groups = Group::query()->with('sources')->orderBy('sort_order')->get();

        return $groups->map(function ($group) {
            if ($group->isNew()) {
                $sources = $this->model
                    ->where('type', Sources::PODCAST)
                    ->where('is_active', true)
                    ->whereDoesntHave('group')
                    ->whereHas('links', function ($query) {
                        $query->where('publish_date', '>=', now()->subDays(5));
                    })
                    ->limit(10)
                    ->get();
            } else {
                $sources = $group->sources;
            }

            return [
                'name'    => $group->name,
                'sources' => $sources
            ];
        });
    }
}
