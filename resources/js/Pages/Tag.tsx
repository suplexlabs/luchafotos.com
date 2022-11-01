import React from 'react'
import Results from '../UI/Results';
import Layout from './Layout'

interface TagProps {
    tag: { name: string },
    results: []
}
interface TagState { }

export default class Tag extends React.Component<TagProps, TagState> {
    constructor(props: TagProps) {
        super(props)
    }

    render(): React.ReactNode {
        return (
            <Layout>
                <h1 className="font-bold text-3xl text-center">
                    Latest {this.props.tag.name} images
                </h1>
                <Results results={this.props.results} />
            </Layout >
        )
    }
}
