<?php

namespace App\Models;

use App\Enums\Links;
use App\Enums\Regexes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

class Link extends Model
{
    use HasFactory;
    use Mediable;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['publish_date', 'featured_until_date'];

    const DEFAULT_IMAGE = 'https://www.thedailysmark.com/img/defaults/iphone-link.png';

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            // check if this link has a bookmark, if so remove it
            Bookmark::where('link_id', $model->id)->delete();
        });
    }

    public function audio()
    {
        return $this->hasOne(LinkAudio::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'link_topics')->withTimestamps();
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function getImages(): array
    {
        if ($this->type == Links::YOUTUBE->value) {
            $id = $this->getYouTubeId();
            $url = "https://static.thedailysmark.com/ytimg/{$id}/hqdefault.jpg";

            return [
                'original'  => $url,
                'medium'    => $url,
                'thumbnail' => $url
            ];
        }

        /** @var \Plank\Mediable\Media $original */
        $original = $this->getMedia('original')->first();
        $medium = $this->getMedia('medium')->first();
        $thumbnail = $this->getMedia('thumbnail')->first();

        return [
            'original'       => $this->getImageUrl($original),
            'medium'         => $this->getImageUrl($medium),
            'thumbnail'      => $this->getImageUrl($thumbnail),
            'originalHeight' => $original ? $original->height : null,
            'originalWidth'  => $original ? $original->width : null,
            'mediumHeight'   => $medium ? $medium->height : null,
            'mediumWidth'    => $medium ? $medium->width : null,
        ];
    }

    /**
     * @param \Plank\Mediable\Media $media
     */
    private function getImageUrl($media): string
    {
        if (!$media) {
            return self::DEFAULT_IMAGE;
        }

        return $media->getUrl();
    }
}
