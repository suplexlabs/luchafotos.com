<script lang="ts">
	import Results from "$lib/ui/Results.svelte";
	import type {PageServerData} from "./$types";

	export let data: PageServerData;
</script>

<svelte:head>
	<title>{data.tag.name} Photos - Lucha Fotos</title>
	<meta name="description" content="Find the {data.tag.name} wrestling photos you love."/>
	<meta name="twitter:title" content="{data.tag.name} Photos - Lucha Fotos"/>
</svelte:head>

<section>
	<h2 class="text-center text-2xl font-bold">
		{data.tag.name} Photos for Today
	</h2>
	<Results results={data.results}/>
</section>
