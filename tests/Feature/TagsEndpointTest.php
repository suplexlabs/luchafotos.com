<?php

use App\Models\Image;
use App\Models\Page;
use App\Models\Site;
use App\Models\Source;
use App\Models\Tag;

test('has endpoint', function () {
    /** @var \Illuminate\Http\Response $response */
    $response = $this->post('/api/tags/similar', ['term' => 'test']);

    $response->assertStatus(200);
    $this->assertEmpty($response->exception);
});

test('has correct results', function () {
    $tag = Tag::factory()->create();

    // NOTE: must commit inserts to make sure test works
    \DB::commit();

    /** @var \Illuminate\Http\Response $response */
    $response = $this->post('/api/tags/similar', ['term' => $tag->name]);
    $json = $response->json();

    expect($json)->toBeArray();

    $results = collect(data_get($json, 'results', []));
    $resultTag = $results->first();

    expect($resultTag)->toBeArray();
    $this->assertEquals($tag->id, $resultTag['id']);
});
