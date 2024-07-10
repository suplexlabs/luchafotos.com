<script>
	import logo from "$lib/images/luchafotos-logo.png";
	import "../app.css";
</script>

<header class="flex justify-center py-2">
	<h1 class="hidden">Lucha Fotos</h1>
	<a href="/">
		<img class="mx-auto" src={logo} alt="The Lucha Fotos logo" width="400" height="98"/>
	</a>
</header>
<slot/>
<footer class="py-10 px-4 font-bold mt-20 text-white text-center">
	&copy; 2022 Lucha Fotos. A <a class="underline" target="_blank" href="https://www.suplexlabs.com">Suplex Labs</a>
	site. Built by <a class="underline" target="_blank" href="https://www.imperez.com">Rich Perez</a>.
</footer>
