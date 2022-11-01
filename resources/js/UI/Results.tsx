import React from 'react'

interface ResultsProp {
    results: Array<{
        id: number,
        url: string,
        title: string,
        site: { domain: string },
        page: { url: string, title: string }
    }>
}
interface ResultsState { }

export default class Results extends React.Component<ResultsProp, ResultsState> {
    render(): React.ReactNode {
        return <ul className="flex flex-wrap">
            {this.props.results.map(result => {
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

    }
}