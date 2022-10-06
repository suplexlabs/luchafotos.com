<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Plank\Mediable\Mediable;

class Image extends Model
{
    use HasFactory;
    use Mediable;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];


    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'image_tags');
    }
}
