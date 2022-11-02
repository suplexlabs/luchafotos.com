<?php

namespace App\Http\Controllers;

use App\Repositories\ImageRepository;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(
        private ImageRepository $repository
    ) {
    }

    public function index()
    {
        $recentImages = $this->repository->getRecent();

        return Inertia::render('Home', [
            'recentImages' => $recentImages,
            'urls' => [
                'search' => route('search.index'),
                'tagsSimilar' => route('tags.similar')
            ]
        ]);
    }
}
