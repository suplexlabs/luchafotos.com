<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lucha Fotos - An image search for wrestling</title>
        <meta charset="UTF-8" />
        <meta name="description" content="An search engine that helps you find the wrestling photos you love without the hassle.">
        <meta name="author" content="Rich Perez">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="icon" type="image/png" href="/favicon.png" />
        <link rel="icon" sizes="180x180" href="/favicon-180.png" />
        <link rel="apple-touch-icon" href="/favicon-152.png" />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="https://www.luchafoots.com" />
        <meta name="twitter:title" content="Lucha Fotos" />

        <!-- Open Graph data -->
        <meta property="og:title" content="Lucha Fotos" />
        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="Lucha Fotos" />
        <meta property="og:url" content="{{request()->url()}}" />

        @vite(['resources/css/app.css', 'resources/js/app.tsx'])
        @yield('extra_scripts')
    </head>
    <body class="bg-brand-dark text-white">
        <header class="mx-auto max-w-2xl text-center">
            <img class="mx-auto" src="/img/luchafotos-logo.png" alt="The Lucha Fotos logo" width="400" />
            <p>An image search for wrestling</p>
        </header>
        @yield('content')
        <footer class="py-10 px-4 font-bold mt-20 text-white text-center">
            &copy; 2022 Lucha Fotos. A <a class="underline" target="_blank" href="https://www.wrestlefive.com">Wrestle Five</a> site. Built by <a class="underline" target="_blank" href="https://mobile.twitter.com/imperez">Rich Perez</a>.
        </footer>

        @if(config('app.env') == 'production')
            <script defer data-domain="luchafotos.com" src="https://plausible.io/js/plausible.js"></script>
        @endif
    </body>
</html>
