<?php

namespace App\Models;

use App\Enums\Sources;
use Diarmuidie\NiceID\NiceID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Source $item) {
            $hasher = new NiceID($item->name . $item->site);
            $hasher->setMinLength(10);

            $item->unique_id = $hasher->encode(1);
        });
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function isCrawler(): bool
    {
        return $this->type == Sources::CRAWLER->value;
    }
}
