<?php

use App\Models\Image;
use App\Models\Page;
use App\Models\Site;
use App\Models\Source;

use function Pest\Laravel\get;

test('has endpoint', function () {
    /** @var \Illuminate\Http\Response $response */
    $response = get(route('search.index', ['term' => 'test']));

    $response->assertStatus(200);
    $this->assertEmpty($response->exception);
});

test('has correct results', function () {
    $source = Source::factory()->create();
    $site = Site::factory()->create();
    $page = Page::factory(null, ['site_id' => $site->id])->create();
    $image = Image::factory(null, ['source_id' => $source->id, 'site_id' => $site->id, 'page_id' => $page->id])->create();

    // NOTE: must commit inserts to make sure test works
    \DB::commit();

    /** @var \Illuminate\Http\Response $response */
    $response = get(route('search.index', ['term' => $image->title]));
    $json = $response->json();

    expect($json)->toBeArray();

    $results = collect(data_get($json, 'results', []));
    $resultImage = $results->first();

    expect($resultImage)->toBeArray();
    $this->assertEquals($image->id, $resultImage['id']);
});
