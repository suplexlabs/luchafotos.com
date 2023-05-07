<script lang="ts">
    export let results: Array<{ name: string }>;
    export let selectTag: Function;
</script>

<ul class="bg-white mt-4">
    {#each results as result (result.name)}
        <li class="p-2 text-stone-400 hover:bg-slate-100 border-b border-dotted border-slate-300">
            <button type="button" class="block w-full text-left cursor-pointer" on:click={selectTag}>
                {result.name}
            </button>
        </li>
    {/each}
</ul>
