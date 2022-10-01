import React, { useEffect } from 'react'
import { Link } from '@inertiajs/inertia-react'

export default function Layout({ children }) {
    return (
        <main>{children}</main>
    )
}
