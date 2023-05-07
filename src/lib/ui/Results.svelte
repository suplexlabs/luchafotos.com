<script lang="ts">
    export let results: Array<Result>;
</script>

<ul class="flex flex-wrap">
    {#each results as result (result.id)}
        <li class="w-full md:w-1/4 p-2">
            <a class="cursor-pointer" href={result.page.url} target="_blank">
                <img class="w-full" src={result.url} alt={result.title} width="300" height="300" />
            </a>
            <div>
                <a
                    class="block p-1 underline cursor-pointer hover:no-underline font-bold"
                    href={result.page.url}
                    target="_blank"
                >
                    {result.page.title}
                </a>
                <a
                    class="block p-1 underline cursor-pointer hover:no-underline text-sm text-gray-50"
                    href={"https://" + result.site.domain}
                    target="_blank"
                >
                    {result.site.domain}
                </a>
            </div>
        </li>
    {/each}
</ul>
