<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Image extends Model
{
    use HasFactory;
    use Mediable;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];
}
