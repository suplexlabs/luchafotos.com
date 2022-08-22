<?php

namespace App\Models;

use App\Enums\Sources;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['lsat_check_date', 'next_check_date'];

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function isCrawler(): bool
    {
        return $this->type == Sources::CRAWLER->value;
    }

    public function getImages(): array
    {
        /** @var \App\Models\Link */
        $link = $this->links->sortByDesc('publish_date')->first();

        if (!$link) {
            $link = new Link();
        }

        return $link->getImages();
    }

    public function getResponse(): array
    {
        return [
            'lastCheckedDate'          => $this->last_check_date,
            'nextCheckDate'            => $this->next_check_date,
            'minutesToCheckForUpdates' => $this->minutes_to_check_for_updates
        ];
    }

    public function getTwitterUsername(): string
    {
        $parts = explode('/', $this->site);
        return array_pop($parts);
    }
}
