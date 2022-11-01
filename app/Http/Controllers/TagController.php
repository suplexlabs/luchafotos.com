<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Repositories\ImageRepository;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends Controller
{
    public function __construct(
        private ImageRepository $repository
    ) {
    }

    public function tag($code)
    {
        $tag = Tag::where('code', $code)->first();
        if (!$tag) {
            abort(404);
        }

        $results = $this->repository->getByTag($tag);

        return Inertia::render('Tag', [
            'tag'     => $tag,
            'results' => $results
        ]);
    }
}
