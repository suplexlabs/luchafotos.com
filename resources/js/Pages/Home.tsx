import React from 'react'
import Layout from './Layout'
import Search from "../UI/Forms/Search";

interface HomeProps { }
interface HomeState { term: string }

export default class Home extends React.Component<HomeProps, HomeState> {
    constructor(props: HomeProps) {
        super(props)

        this.searchUpdate = this.searchUpdate.bind(this)
        this.state = { term: '' }
    }

    searchUpdate(term: string) {
        this.setState({ term })
    }

    render() {
        return (
            <Layout>
                <form className="max-w-lg mx-auto p-2 mt-10">
                    <Search search={this.searchUpdate} term={this.state.term} />
                </form>
            </Layout>
        )
    }
}
