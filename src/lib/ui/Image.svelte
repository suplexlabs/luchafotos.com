<script lang="ts">
    export let image: Image;
</script>

<figure class="relative mb-2">
    {#if image.tags}
        <nav class="absolute flex flex-wrap gap-1 justify-end top-2 right-2">
            {#each image.tags as tag (tag.code)}
                <a class="btn btn-primary btn-xs drop-shadow-md" href="{tag.code}-photos" data-sveltekit-reload>{tag.name}</a>
            {/each}
        </nav>
    {/if}
    <img class="rounded" loading="lazy" src={image.url} alt={image.title} height={image.height} width={image.width} />
    <figcaption class="bg-black p-2 rounded-b">
        <a class="block p-1 underline hover:no-underline font-bold" href={image.page.url} target="_blank">
            {image.page.title}
        </a>
        <a
            class="block p-1 underline hover:no-underline text-sm text-gray-50"
            href={"https://" + image.site.domain}
            target="_blank"
        >
            {image.site.domain}
        </a>
    </figcaption>
</figure>
