<?php

use App\Datas\ImageData;
use App\Jobs\SaveImage;
use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('saves an image to the database', function () {
    // setup data
    $data = ImageData::from([
        'title'   => 'Test Image',
        'url'     => 'https://www.luchafotos.com/img/luchafotos-logo.png',
        'domain'  => 'www.test.com',
        'pageUrl' => 'https://www.example.com'
    ]);
    $source = Source::factory()->create();

    // create job
    $job = new SaveImage($data, $source);
    $job->dispatchSync($data, $source);

    // assets
    $this->assertDatabaseHas('images', Arr::only($data->toArray(), ['url']));
});
