<script lang="ts">
    import Results from "$lib/ui/Results.svelte";
    import Search from "$lib/ui/Search.svelte";
    import type { PageServerData } from "./$types";

    export let data: PageServerData;
</script>

<form class="max-w-lg mx-auto p-2 mt-10 mb-4" action="/search">
    <Search />
</form>
<section>
    <h2 class="text-center text-2xl font-bold">Recent Images for Today</h2>
    <Results results={data.results} />
</section>
