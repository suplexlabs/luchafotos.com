<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Services\SearchService;

class SearchController extends Controller
{
    public function __construct(
        private SearchService $service
    ) {
    }

    public function index(SearchRequest $request)
    {
        $results = $this->service->perform($request->get('term'));

        return response()->json([
            'results' => $results
        ]);
    }
}
