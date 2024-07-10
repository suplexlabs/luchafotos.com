import feed from "../lib/data/feed";

export async function load({}) {
	const json: { tags: Array<Tag> } = feed;

	return {
		tags: json
	}
}