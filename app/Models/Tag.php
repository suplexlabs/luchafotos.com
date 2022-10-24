<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingFullText;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $guarded = ['id'];
    protected $casts = [
        'extras' => 'array'
    ];

    #[SearchUsingFullText(['title'])]
    public function toSearchableArray()
    {
        return $this->toArray();
    }
}
