<?php

use App\Datas\ImageData;
use App\Models\Site;
use App\Models\Source;
use App\Repositories\ImageRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('can save image', function () {
    // setup data
    $data = ImageData::from([
        'title'   => 'Test Image',
        'url'     => 'https://www.luchafotos.com/img/luchafotos-logo.png',
        'domain'  => 'www.test.com',
        'pageUrl' => 'https://www.example.com'
    ]);

    $source = Source::factory()->create();

    /** @var ImageRepository $repository */
    $repository = app(ImageRepository::class);
    $image = $repository->createByData($source, $data);

    // asserts
    $this->assertDatabaseHas('images', $image->only(['url']));
});
