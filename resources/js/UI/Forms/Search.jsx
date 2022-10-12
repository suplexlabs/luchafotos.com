import React from "react";

export default class Search extends React.Component {
    constructor(props) {
        super(props)
        this.search = this.search.bind(this);
    }

    render() {
        return (
            <div className="flex flex-col gap-4 text-center text-2xl">
                <label htmlFor="search">I want to find an image of...</label>
                <input id="search" className="p-4 border-4 border-yellow-400 text-stone-600" type="search" placeholder="Seth Rollins" value={this.props.term} onChange={this.search} />
            </div>
        );
    }

    search(event) {
        this.props.search(event.target.value)
    }
}
