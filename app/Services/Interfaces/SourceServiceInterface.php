<?php

namespace App\Services\Interfaces;

interface SourceServiceInterface {
    function load(string $url, array $params = []): mixed;
}