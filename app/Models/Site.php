<?php

namespace App\Models;

use App\Enums\Companies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = ['id'];

    public function isCompany(Companies $company): bool
    {
        return stripos($this->domain, $company->value) !== false;
    }
}
