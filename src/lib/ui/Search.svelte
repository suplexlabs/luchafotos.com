<script lang="ts">
    export let term: string = "";
    export let searchChange: Function;
    export let searchSelected: Function;
</script>

<div>
    <div class="flex flex-col gap-4 text-center">
        <label class="text-2xl" for="search">I want to find an image of...</label>
        <div class="flex gap-2">
            <input
                class="p-4 text-stone-600 focus:shadow-lg focus:shadow-stone-600 flex-grow"
                id="search"
                type="search"
                on:change={searchChange}
                value={term}
                autoComplete="false"
            />
            <button
                class="bg-yellow-300 text-stone-600 px-4 py-2 font-bold hover:bg-yellow-400"
                on:click={searchSelected}
            >
                search
            </button>
        </div>
    </div>
</div>
