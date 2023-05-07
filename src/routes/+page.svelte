<script lang="ts">
    import Results from "$lib/ui/Results.svelte";
    import Search from "$lib/ui/Search.svelte";
    import Autocomplete from "$lib/ui/Autocomplete.svelte";

    let term: string = "";
    let searchStartTime: number = 0;
    let searchEndTime: number = 0;
    let searchResults: Array<Image>;
    let autocompleteResults: Array<{ name: string }>;

    const searchSelected = (term: string) => {
        this.setState({ term, searchStartTime: Date.now(), autocompleteResults: [] });

        axios.get(this.props.urls.search, { params: { term } }).then((response) => {
            this.setState({
                searchResults: response.data.results || [],
                searchEndTime: Date.now(),
            });
        });
    };

    const searchChange = (term: string) => {
        this.setState({ term });

        axios.get(this.props.urls.tagsSimilar, { params: { tag: term } }).then((response) => {
            this.setState({ autocompleteResults: response.data.results || [] });
        });
    };

    const autocompleteSelect = (term: string) => {
        searchSelected(term);
    };
    const formatSearchLoadTime = (): string | null => {
        const startTime = searchStartTime;
        const endTime = searchEndTime;

        const milliDiff = endTime - startTime;
        if (milliDiff) {
            return (milliDiff / 1000).toFixed(2);
        }

        return null;
    };

    let loadTime = formatSearchLoadTime();
</script>

<form class="max-w-lg mx-auto p-2 mt-10 mb-4">
    <Search {searchChange} {searchSelected} {term} />
    <Autocomplete selectTag={autocompleteSelect} results={autocompleteResults} />
</form>
<section>
    <h2 class="text-center text-2xl font-bold">
        {#if term}
            Latest {term} images
        {:else}
            Recent Images for Today
        {/if}
    </h2>
    {#if numResults && loadTime}
        <p class="text-right px-2 text-sm">We found {numResults} images in {loadTime} secs.</p>
    {/if}
    <Results {results} />
</section>
