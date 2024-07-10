interface Image {
	id: number,
	url: string,
	title: string,
	height: number,
	width: number,
	site: { domain: string },
	page: { url: string, title: string },
	tags: Tag[]
}

interface Result {
	id: number,
	url: string,
	title: string,
	height: number,
	width: number,
	site: { domain: string },
	page: { url: string, title: string }
	tags: Tag[]
}

interface Tag {
	name: string,
	code: string,
	type: string,
	images: Image[]
}

interface AutocompleteResult {
	name: string
}
