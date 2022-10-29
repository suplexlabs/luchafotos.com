<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'urls' => [
                'search' => route('search.index'),
                'tagsSimilar' => route('tags.similar')
            ]
        ]);
    }
}
