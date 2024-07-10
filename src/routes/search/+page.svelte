<script lang="ts">
    import Results from "$lib/ui/Results.svelte";
    import Search from "$lib/ui/Search.svelte";
    import type { PageServerData } from "./$types";

    export let data: PageServerData;
</script>

<svelte:head>
    <title>Search {data.term} - Lucha Fotos</title>
    <meta name="description" content="Search for {data.term} wrestling photos you love." />
    <meta name="twitter:title" content="Search {data.term} - Lucha Fotos" />
</svelte:head>

<Search term={data.term} />
<section>
    <h2 class="text-center text-2xl font-bold">
        Latest {data.term} photos
    </h2>
    <Results results={data.results} />
</section>
