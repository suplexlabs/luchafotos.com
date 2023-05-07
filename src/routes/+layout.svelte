<script>
    import logo from "$lib/images/luchafotos-logo.png";
    import "../app.css";
</script>

<header class="mx-auto max-w-2xl text-center mb-8">
    <h1 class="hidden">Lucha Fotos</h1>
    <a href="/">
        <img class="mx-auto" src={logo} alt="The Lucha Fotos logo" width="400" />
    </a>
    <p>An image search for wrestling</p>
</header>
<slot />
<footer class="py-10 px-4 font-bold mt-20 text-white text-center">
    &copy; 2022 Lucha Fotos. A <a class="underline" target="_blank" href="https://www.suplexlabs.com">Suplex Labs</a>
    site. Built by <a class="underline" target="_blank" href="https://mobile.twitter.com/imperez">Rich Perez</a>.
</footer>
