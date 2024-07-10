import type {PageServerLoad} from './$types';
import feed from "$lib/data/feed";

export const load: PageServerLoad = async function ({params}) {
	const tagCode = params.tag;

	let items = feed.filter(item => item.images.find(image => {
		return image.tags.flatMap(tag => tag.code).includes(tagCode)
	}));
	let images = items.flatMap(item => item.images);

	return {
		tag: images[0].tags[0],
		results: images,
	}
}