import React from "react";
import axios from "axios";

interface AutocompleteProps {
    term: string,
    endpoint: string
}

interface AutocompleteState {
    results: Array<{ label: string }>
}

export default class Autocomplete extends React.Component<AutocompleteProps, AutocompleteState> {
    constructor(props: AutocompleteProps) {
        super(props)

        this.state = { results: [] }
    }

    componentDidUpdate(prevProps: Readonly<AutocompleteProps>, prevState: Readonly<AutocompleteState>, snapshot?: any): void {
        // axios.get(this.props.endpoint).then(response => {
        //     this.setState({ results: response.data.results });
        // })
    }

    render() {
        return <ul>
            {this.state.results.map(result => {
                return <li>{result.label}</li>
            })}
        </ul>
    }
}