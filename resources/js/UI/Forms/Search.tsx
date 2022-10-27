import React, { RefObject } from "react";

interface SearchProps {
    term: string,
    searchHandler: Function
}
interface SearchState { }

export default class Search extends React.Component<SearchProps, SearchState> {
    inputRef: RefObject<HTMLInputElement>;

    constructor(props: SearchProps) {
        super(props)

        this.search = this.search.bind(this);
        this.inputRef = React.createRef();
    }

    componentDidMount() {
        this.inputRef.current?.focus();
    }

    render() {
        return (
            <div>
                <div className="flex flex-col gap-4 text-center text-2xl">
                    <label htmlFor="search">I want to find an image of...</label>
                    <input
                        className="p-4 text-stone-600 focus:shadow-xl focus:shadow-blue-400 border-4 border-yellow-300 appearance-none"
                        id="search"
                        ref={this.inputRef}
                        type="search"
                        placeholder="Seth Rollins"
                        value={this.props.term}
                        onChange={this.search}
                        autoComplete="false"
                    />
                </div>
            </div>
        );
    }

    search(event: React.ChangeEvent) {
        this.props.searchHandler(event.target.value)
    }
}
