
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            Lucha Fotos
        </title>

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-brand-dark text-white">
        @yield('content')

        @if(config('app.env') == 'production')
            <script defer data-domain="luchafotos.com" src="https://plausible.io/js/plausible.js"></script>
        @endif
    </body>
</html>
