import React from 'react'
import Layout from './Layout'
import Search from "../UI/Forms/Search";

export default class Home extends React.Component {
    constructor(props) {
        super(props)

        this.searchUpdate = this.searchUpdate.bind(this)
        this.state = { term: '' }
    }

    searchUpdate(term) {
        this.setState({ term })
    }

    render() {
        return (
            <Layout>
                <form className="max-w-lg mx-auto p-2 mt-10">
                    <Search search={this.searchUpdate} term={this.state.term} />
                </form>
            </Layout >
        )
    }
}
