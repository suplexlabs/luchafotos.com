<?php

use App\Enums\Companies;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('site->isCompany', function () {
    $wweSite = new Site(['domain' => 'www.wwe.com']);
    $impactSite = new Site(['domain' => 'impactwrestling.com']);

    expect($wweSite->isCompany(Companies::WWE))->toBeTrue();
    expect($impactSite->isCompany(Companies::IMPACT))->toBeTrue();
});
