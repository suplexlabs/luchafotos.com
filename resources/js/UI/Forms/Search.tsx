import React, { RefObject } from "react";

interface SearchProps {
    term: string,
    searchSelectedHandler: Function,
    searchChangeHandler: Function
}
interface SearchState {
    term: string
}

export default class Search extends React.Component<SearchProps, SearchState> {
    inputRef: RefObject<HTMLInputElement>;

    constructor(props: SearchProps) {
        super(props)

        this.state = { term: '' }

        this.searchChange = this.searchChange.bind(this);
        this.searchSelected = this.searchSelected.bind(this);
        this.inputRef = React.createRef();
    }

    componentDidMount() {
        this.inputRef.current?.focus();
    }

    render() {
        return (
            <div>
                <div className="flex flex-col gap-4 text-center">
                    <label className="text-2xl" htmlFor="search">I want to find an image of...</label>
                    <div className="flex gap-2">
                        <input
                            className="p-4 text-stone-600 focus:shadow-lg focus:shadow-stone-600 flex-grow"
                            id="search"
                            ref={this.inputRef}
                            type="search"
                            onChange={this.searchChange}
                            value={this.props.term || this.state.term}
                            autoComplete="false"
                        />
                        <button
                            className="bg-yellow-300 text-stone-600 px-4 py-2 font-bold hover:bg-yellow-400"
                            onClick={this.searchSelected}
                        >search</button>
                    </div>
                </div>
            </div>
        );
    }

    searchChange(event: React.SyntheticEvent) {
        const term = this.inputRef.current?.value || ''
        this.setState({ term })

        this.props.searchChangeHandler(term)

        if (!term) {
            this.searchSelected(event)
        }
    }

    searchSelected(event: React.SyntheticEvent) {
        event.preventDefault()

        this.props.searchSelectedHandler(this.inputRef.current?.value)
    }
}
