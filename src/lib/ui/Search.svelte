<script lang="ts">
	import Autocomplete from "$lib/ui/Autocomplete.svelte";
	import autocomplete from "$lib/data/autocomplete";

	export let term: string = "";
	let autoCompleteTags: Array<AutocompleteResult> = [];

	const getAutocompleteTags = async (event: Event) => {
		const tag = event.currentTarget?.value;

		if (tag) {
			autoCompleteTags = autocomplete;
		} else {
			autoCompleteTags = [];
		}
	};
</script>

<form class="max-w-4xl mx-auto p-2" action="/search">
	<div class="flex flex-col gap-2 text-center">
		<label class="text-2xl" for="search">I want to find a photo of</label>
		<div class="flex gap-1">
			<input
				class="p-4 text-stone-600 focus:shadow-lg focus:shadow-stone-600 flex-grow"
				id="search"
				type="search"
				name="term"
				value={term}
				autoComplete="false"
				placeholder="Enter a wrestler's name to find their photos"
				on:input={getAutocompleteTags}
			/>
			<button class="bg-yellow-300 text-stone-600 px-6 py-2 font-bold hover:bg-yellow-400">search</button>
		</div>
	</div>
	<Autocomplete results={autoCompleteTags}/>
</form>
