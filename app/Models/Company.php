<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function scopeOfficial($query)
    {
        $query->where('is_official', true);
    }

    public function links()
    {
        return $this->belongsToMany(Link::class, 'link_companies')->withTimestamps();
    }
}
