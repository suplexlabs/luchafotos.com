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
        const numResults = this.state.results.length;

        return (
            <Layout>
                <form className="max-w-lg mx-auto p-2 mt-10 mb-4">
                    <Search search={this.searchUpdate} term={this.state.term} />
                </form>
                <div>
                    {numResults ? <p className="text-lg text-center font-bold">We found {numResults} images</p> : null}
                    <ul className="flex flex-wrap">
                        {this.state.results.map(result => {
                            return <li className="w-full md:w-1/4 p-2" key={result.id}>
                                <a className="cursor-pointer" href={result.page.url} target="_blank">
                                    <img className="w-full" src={result.url} alt={result.title} width="300" />
                                </a>
                                <div>
                                    <a className="block underline cursor-pointer hover:no-underline" href={result.page.url} target="_blank">{result.page.title}</a>
                                    <a className="block underline cursor-pointer hover:no-underline" href={'https://' + result.site.domain} target="_blank">{result.site.domain}</a>
                                </div>
                            </li>
                        })}
                    </ul>
                </div>
            </Layout>
        )
    }
}
