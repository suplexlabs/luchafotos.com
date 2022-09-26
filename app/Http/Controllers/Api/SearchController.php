<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index()
    {
        $results = [];

        return response()->json([
            'results' => $results
        ]);
    }
}
