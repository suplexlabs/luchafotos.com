import type { PageServerLoad } from './$types';

export const load: PageServerLoad = async function ({ fetch, url }) {
    const loadStart = (new Date()).getTime();
    const term = url.searchParams.get('term');

    const response = await fetch(`https://www.smarkbot.xyz/api/images/search?term=${term}`);
    const json = await response.json();

    let loadFinished = (new Date()).getTime();

    const milliDiff = loadFinished - loadStart;
    const loadTime = (milliDiff / 1000).toFixed(2);

    return {
        term,
        results: json.results,
        loadTime
    }
}