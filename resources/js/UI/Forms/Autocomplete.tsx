import React from "react";
import axios from "axios";

interface AutocompleteProps {
    tag: string,
    endpoint: string,
    selectTagHandler: Function
}

interface AutocompleteState {
    results: Array<{ name: string }>
}

export default class Autocomplete extends React.Component<AutocompleteProps, AutocompleteState> {
    constructor(props: AutocompleteProps) {
        super(props)

        this.selectTag = this.selectTag.bind(this)
        this.state = { results: [] }
    }

    shouldComponentUpdate(nextProps: Readonly<AutocompleteProps>, nextState: Readonly<AutocompleteState>, nextContext: any): boolean {
        return nextProps.tag != this.props.tag
    }

    componentDidUpdate(prevProps: Readonly<AutocompleteProps>, prevState: Readonly<AutocompleteState>, snapshot?: any): void {
        const tag = this.props.tag
        axios.get(this.props.endpoint, { params: { tag } })
            .then(response => {
                this.setState({ results: response.data.results || [] });
            })
    }

    selectTag(event: React.SyntheticEvent) {
        this.props.selectTagHandler(event.target.innerHTML)
    }

    render() {
        return <ul className="bg-white">
            {
                this.state.results.map(result => {
                    return <li className="p-2 text-stone-400 hover:bg-slate-100" key={result.name}>
                        <button type="button" onClick={this.selectTag}>{result.name}</button>
                    </li>
                })
            }
        </ul >
    }
}