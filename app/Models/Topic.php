<?php

namespace App\Models;

use App\Enums\Links;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $casts = [
        'aliases' => 'array'
    ];

    public function articles()
    {
        return $this->belongsToMany(Link::class, 'link_topics')
            ->where('type', Links::ARTICLE)
            ->orderBy('publish_date', 'desc');
    }
}
