<?php

test('has endpoint', function () {
    $response = $this->get('/api/search');
    $response->assertStatus(200);
});
