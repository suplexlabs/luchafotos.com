import React from 'react'
import { render } from 'react-dom'
import { createInertiaApp } from '@inertiajs/inertia-react'
import { InertiaProgress } from '@inertiajs/progress'

InertiaProgress.init()

function resolvePageComponent(name, pages) {
    for (const path in pages) {
        if (path.endsWith(`${name.replace('.', '/')}.jsx`)) {
            return typeof pages[path] === 'function'
                ? pages[path]()
                : pages[path]
        }
    }

    throw new Error(`Page not found: ${name}`)
}

createInertiaApp({
    resolve: name => resolvePageComponent(name, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        render(<App {...props} />, el)
    },
    output: {
        chunkFilename: 'js/[name].js?id=[chunkhash]',
    }
})
