<?php

use App\Models\Tag;

use function Pest\Laravel\get;

test('has endpoint', function () {
    /** @var \Illuminate\Http\Response $response */
    $response = get(route('tags.similar', ['tag' => 'test']));

    $response->assertStatus(200);
    $this->assertEmpty($response->exception);
});

test('has correct results', function () {
    $tag = Tag::factory()->create();

    // NOTE: must commit inserts to make sure test works
    \DB::commit();

    /** @var \Illuminate\Http\Response $response */
    $response = get(route('tags.similar', ['tag' => $tag->name]));
    $json = $response->json();


    expect($json)->toBeArray();

    $results = collect(data_get($json, 'results', []));
    $resultTag = $results->first();

    expect($resultTag)->toBeArray();
    $this->assertEquals($tag->id, $resultTag['id']);
});
