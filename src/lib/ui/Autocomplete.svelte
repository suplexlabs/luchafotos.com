<script lang="ts">
	export let results: Array<AutocompleteResult> = [];
</script>

<ul class="bg-white mt-4">
	{#each results as result (result.name)}
		<li class="p-2 text-stone-400 hover:bg-slate-100 border-b border-dotted border-slate-300">
			<a class="block w-full text-left cursor-pointer" href="/search?term={result.name}">
				{result.name}
			</a>
		</li>
	{/each}
</ul>
