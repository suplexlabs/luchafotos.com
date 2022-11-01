<?php

if (!function_exists('pageTitle')) {
    function pageTitle()
    {
        $request = request();
        $code = $request->route('code');

        if ($code) {
            $tag = \App\Models\Tag::whereCode($code)->first();

            if ($tag) {
                return "Latest {$tag->name} images - Lucha Fotos";
            }
        }

        return 'An image search for wrestling - Lucha Fotos';
    }
}
