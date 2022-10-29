import React from 'react'
import axios from "axios";
import Layout from './Layout'
import Search from "../UI/Forms/Search";
import Autocomplete from '../UI/Forms/Autocomplete';

interface HomeProps { urls: { search: string, tagsSimilar: string } }
interface HomeState {
    term: string,
    searchStartTime?: number,
    searchEndTime?: number,
    autocompleteResults: Array<{ name: string }>,
    searchResults: Array<{
        id: number,
        url: string,
        title: string,
        site: { domain: string },
        page: { url: string, title: string }
    }>
}

export default class Home extends React.Component<HomeProps, HomeState> {
    constructor(props: HomeProps) {
        super(props)

        this.searchUpdate = this.searchUpdate.bind(this)
        this.state = { term: '', searchResults: [], autocompleteResults: [] }
    }

    searchUpdate(term: string) {
        this.setState({ term, searchStartTime: Date.now() })

        axios.get(this.props.urls.search, { params: { term } })
            .then((response) => {
                this.setState({
                    searchResults: response.data.results || [],
                    searchEndTime: Date.now()
                })
            })

        axios.get(this.props.urls.tagsSimilar, { params: { tag: term } })
            .then(response => {
                this.setState({ autocompleteResults: response.data.results || [] });
            })
    }

    formatSearchLoadTime(): string {
        const startTime = this.state.searchStartTime || 0;
        const endTime = this.state.searchEndTime || 0;

        const milliDiff = endTime - startTime;
        return (milliDiff / 1000).toFixed(2);
    }

    render() {
        const numResults = this.state.searchResults.length;

        return (
            <Layout>
                <form className="max-w-lg mx-auto p-2 mt-10 mb-4">
                    <Search searchHandler={this.searchUpdate} term={this.state.term} />
                    <Autocomplete selectTagHandler={this.searchUpdate} tag={this.state.term} results={this.state.autocompleteResults} />
                </form>
                <div>
                    {numResults ? <p className="text-lg text-center font-bold">We found {numResults} images in {this.formatSearchLoadTime()} secs.</p> : null}
                    <ul className="flex flex-wrap">
                        {this.state.searchResults.map(result => {
                            return <li className="w-full md:w-1/4 p-2" key={result.id.toString()}>
                                < a className="cursor-pointer" href={result.page.url} target="_blank" >
                                    <img className="w-full" src={result.url} alt={result.title} width="300" />
                                </a>
                                <div>
                                    <a className="block underline cursor-pointer hover:no-underline" href={result.page.url} target="_blank">{result.page.title}</a>
                                    <a className="block underline cursor-pointer hover:no-underline" href={'https://' + result.site.domain} target="_blank">{result.site.domain}</a>
                                </div>
                            </li>
                        })}
                    </ul>
                </div >
            </Layout >
        )
    }
}
