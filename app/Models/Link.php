<?php

namespace App\Models;

use App\Enums\Links;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['publish_at'];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}
