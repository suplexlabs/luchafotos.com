<script lang="ts">
    import Results from "$lib/ui/Results.svelte";
    import Search from "$lib/ui/Search.svelte";
    import Autocomplete from "$lib/ui/Autocomplete.svelte";
    import type { PageServerData } from "./$types";

    export let data: PageServerData;
</script>

<form class="max-w-lg mx-auto p-2 mt-10 mb-4" action="/search">
    <Search term={data.term} />
</form>
<section>
    <h2 class="text-center text-2xl font-bold">
        Latest {data.term} images
    </h2>
    {#if data.results.length && data.loadTime}
        <p class="text-right px-2 text-sm">We found {data.results.length} images in {data.loadTime} secs.</p>
    {/if}
    <Results results={data.results} />
</section>
