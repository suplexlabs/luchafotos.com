<?php

use App\Models\Tag;

use function Pest\Laravel\get;

test('has endpoint', function () {
    /** @var \Illuminate\Http\Response $response */
    $response = get(route('tags.similar', ['tag' => 'test']));

    $response->assertStatus(200);
    $this->assertEmpty($response->exception);
});

test('has no results', function () {
    /** @var \Illuminate\Http\Response $response */
    $response = get(route('tags.similar', ['tag' => null]));
    $json = $response->json();

    expect($json)->toBeArray();

    $results = collect(data_get($json, 'results', []));

    $resultTag = $results->first();

    expect($resultTag)->toBeNull();
    expect($results)->toBeEmpty();
});

test('has correct results', function () {
    $tag = Tag::factory()->create();

    // NOTE: must commit inserts to make sure test works
    \DB::commit();

    $name = substr($tag->name, 0, 4);

    /** @var \Illuminate\Http\Response $response */
    $response = get(route('tags.similar', ['tag' => $name]));
    $json = $response->json();

    expect($json)->toBeArray();

    $results = collect(data_get($json, 'results', []));
    $resultTag = $results->first();

    expect($resultTag)->toBeArray();
    expect($resultTag['name'])->toBeTruthy();
    $this->assertEquals($tag->id, $resultTag['id']);
});
