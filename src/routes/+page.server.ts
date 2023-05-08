export async function load({ params }) {
    const response = await fetch(`https://www.smarkbot.xyz/api/images/search?term=`);
    const json = await response.json();

    return {
        results: json.results
    }
}