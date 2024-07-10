<script lang="ts">
	import Image from "$lib/ui/Image.svelte";
	import Search from "$lib/ui/Search.svelte";
	import type {PageServerData} from "./$types";

	export let data: PageServerData;
</script>

<svelte:head>
	<title>Lucha Fotos - Find the wrestling photos you love</title>
	<meta name="description" content="Find the wrestling photos you love"/>
	<meta name="twitter:title" content="Lucha Fotos"/>
</svelte:head>

<Search/>

<section>
	<ul class="columns-1 md:columns-3 gap-2">
		{#each data.tags as tag (tag.code)}
			{#if tag.images}
				{#each tag.images as image}
					<li class="break-inside-avoid">
						<Image {image}/>
					</li>
				{/each}
			{/if}
		{/each}
	</ul>
</section>
