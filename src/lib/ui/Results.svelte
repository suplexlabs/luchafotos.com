<script lang="ts">
    import Image from "$lib/ui/Image.svelte";

    export let results: Array<Result>;
</script>

<ul class="columns-1 md:columns-3 gap-2">
    {#each results as result (result.id)}
        <li class="break-inside-avoid">
            <Image image={result} />
        </li>
    {/each}
</ul>
