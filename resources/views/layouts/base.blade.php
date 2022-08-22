<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lucha Fotos</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-brand-dark text-white">
        <main>
            @yield('content')
        </main>
        <footer class="flex flex-wrap-reverse gap-10 py-10 px-4 font-bold mt-20 bg-stone-900 text-white">
            <div>
                <ul class="flex flex-wrap gap-4 list-none p-0">
                    <li class="text-gray-400">&copy; 2022. Lucha Fotos. A <a class="underline" target="_blank" href="https://www.wrestlefive.com">Wrestle Five</a> site.</li>
                </ul>
            </div>
        </footer>

        @if(config('app.env') == 'production')
            <script defer data-domain="luchafotos.com" src="https://plausible.io/js/plausible.js"></script>
        @endif
    </body>
</html>
