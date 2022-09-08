<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Plank\Mediable\Mediable;

class Image extends Model
{
    use HasFactory;
    use Mediable;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];


    public function source(): HasOne
    {
        return $this->hasOne(Source::class);
    }

    public function site(): HasOne
    {
        return $this->hasOne(Site::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'image_tags');
    }
}
