<script lang="ts">
    import Autocomplete from "$lib/ui/Autocomplete.svelte";
    import { redirect } from "@sveltejs/kit";

    export let term: string = "";
    let autoCompleteTags: Array<{ name: string }> = [];

    const getAutocompleteTags = async (event: Event) => {
        const tag = event.currentTarget?.value;

        if (tag) {
            const response = await fetch(`https://www.smarkbot.xyz/api/tags/similar?tag=${tag}`);
            const json = await response.json();

            autoCompleteTags = json.results;
        } else {
            autoCompleteTags = [];
        }
    };
</script>

<div class="flex flex-col gap-4 text-center">
    <label class="text-2xl" for="search">I want to find an image of...</label>
    <div class="flex gap-2">
        <input
            class="p-4 text-stone-600 focus:shadow-lg focus:shadow-stone-600 flex-grow"
            id="search"
            type="search"
            name="term"
            value={term}
            autoComplete="false"
            placeholder="enter a wrestler name"
            on:input={getAutocompleteTags}
        />
        <button class="bg-yellow-300 text-stone-600 px-4 py-2 font-bold hover:bg-yellow-400">search</button>
    </div>
</div>
<Autocomplete results={autoCompleteTags} />
