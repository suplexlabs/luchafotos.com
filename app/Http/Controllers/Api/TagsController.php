<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Repositories\TagRepository;

class TagsController extends Controller
{
    public function __construct(
        private TagRepository $repository
    ) {
    }

    public function similar(TagRequest $request)
    {
        $results = $this->repository->getSimilar($request->get('tag'));

        return response()->json([
            'results' => $results
        ]);
    }
}
