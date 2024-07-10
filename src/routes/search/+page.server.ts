import type {PageServerLoad} from './$types';
import results from "$lib/data/results";

export const load: PageServerLoad = async function ({fetch, url}) {
	const term = url.searchParams.get('term');
	const json = results.filter(result => result.title.includes(term));

	return {
		term,
		results: json,
	}
}