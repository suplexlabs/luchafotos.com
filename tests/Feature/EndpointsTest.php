<?php

use function Pest\Laravel\get;

it('has search endpoint', function () {
    $response = $this->get('/api/search');
    $response->assertStatus(200);
});
