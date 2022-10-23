import React from 'react'
import Layout from './Layout'
import Search from "../UI/Forms/Search";
import axios from "axios";

interface HomeProps { urls: { search: string } }
interface HomeState { term: string, results: Array<Object> }

export default class Home extends React.Component<HomeProps, HomeState> {
    constructor(props: HomeProps) {
        super(props)

        this.searchUpdate = this.searchUpdate.bind(this)
        this.state = { term: '', results: [] }
    }

    searchUpdate(term: string) {
        this.setState({ term })

        axios.post(this.props.urls.search, { term })
            .then(response => {
                this.setState({ results: response.data.results || [] })
            })

    }

    render() {
        return (
            <Layout>
                <form className="max-w-lg mx-auto p-2 mt-10">
                    <Search search={this.searchUpdate} term={this.state.term} />
                </form>
                <ul>
                    {this.state.results.map(result => {
                        return <li key={result.id}>
                            {result.title}
                        </li>;
                    })}
                </ul>
            </Layout>
        )
    }
}
