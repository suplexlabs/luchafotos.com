
import React, { RefObject } from "react";

interface SearchProps {
    term: string,
    search: Function
}
interface SearchState { }

export default class Search extends React.Component<SearchProps, SearchState> {
    public inputRef: RefObject<HTMLInputElement>;

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
            <div className="flex flex-col gap-4 text-center text-2xl">
                <label htmlFor="search">I want to find an image of...</label>
                <input
                    className="p-4 text-stone-600 focus:outline focus:outline-yellow-400"
                    id="search"
                    ref={this.inputRef}
                    type="search"
                    placeholder="Seth Rollins"
                    value={this.props.term}
                    onChange={this.search}
                />
            </div>
        );
    }

    search(event: React.ChangeEvent) {
        this.props.search(event.target.nodeValue)
    }
}
