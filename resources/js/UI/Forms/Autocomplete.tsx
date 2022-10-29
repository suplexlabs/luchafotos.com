import React from "react";

interface AutocompleteProps {
    tag: string,
    results: Array<{ name: string }>,
    selectTagHandler: Function
}

interface AutocompleteState { }

export default class Autocomplete extends React.Component<AutocompleteProps, AutocompleteState> {
    constructor(props: AutocompleteProps) {
        super(props)

        this.selectTag = this.selectTag.bind(this)
    }

    selectTag(event: React.MouseEvent) {
        const target = event.target as HTMLButtonElement
        this.props.selectTagHandler(target.innerHTML)
    }

    render() {
        return <ul className="bg-white">
            {
                this.props.results.map(result => {
                    return <li className="p-2 text-stone-400 hover:bg-slate-100" key={result.name}>
                        <button type="button" onClick={this.selectTag}>{result.name}</button>
                    </li>
                })
            }
        </ul>
    }
}