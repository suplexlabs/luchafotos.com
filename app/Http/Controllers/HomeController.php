<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return Inertia::render('Home', [
            'urls' => [
                'search' => route('search.index')
            ]
        ]);
    }
}
