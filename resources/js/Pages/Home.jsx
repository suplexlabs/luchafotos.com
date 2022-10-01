import React from 'react'
import Layout from './Layout'

export default function Welcome({ user }) {
    return (
        <Layout>
            <div className="mx-auto max-w-2xl text-center mt-10">
                <p className="mt-4 text-3xl mx-20">
                    An upcoming search engine that helps you find the wrestling photos you love without the hassle.
                </p>
            </div>
        </Layout >
    )
}
