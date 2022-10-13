import React from "react";

export default class Search extends React.Component {
    constructor(props) {
        super(props)

        this.search = this.search.bind(this);
        this.inputRef = React.createRef();
    }

    componentDidMount() {
        this.inputRef.current.focus();
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

    search(event) {
        this.props.search(event.target.value)
    }
}
