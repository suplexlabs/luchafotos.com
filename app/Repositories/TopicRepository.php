<?php

namespace App\Repositories;

use App\Enums\Topics;
use App\Models\Topic;
use App\Repositories\BaseRepository;
use Illuminate\Support\Str;

class TopicRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Topic::class;
    }

    public function getCurrentTopics()
    {
        return $this->model
            ->withCount('articles')
            ->having('articles_count', '>', 3)
            ->get();
    }

    public function createCompanyTopic(string $name, array $aliases = [])
    {
        $code = Str::slug($name);

        $this->updateOrCreate(
            ['code' => $code],
            [
                'name' => $name,
                'code' => $code,
                'type' => Topics::COMPANY,
                'aliases' => $aliases,
            ]
        );
    }

    public function createShowTopic(string $name, array $aliases = null)
    {
        $name = trim(preg_replace('/\d{4}/', '', $name));
        if (strtolower($name) == 'tba') {
            return;
        }

        $code = Str::slug($name);
        $this->updateOrCreate(
            ['code' => $code],
            [
                'name' => $name,
                'code' => $code,
                'type' => Topics::SHOW,
                'aliases' => $aliases,
            ]
        );
    }

    public function createKeywordTopic(string $name, array $aliases = null)
    {
        $code = Str::slug($name);
        $this->updateOrCreate(
            ['code' => $code],
            [
                'name' => $name,
                'code' => $code,
                'type' => Topics::KEYWORD,
                'aliases' => $aliases,
            ]
        );
    }
}
