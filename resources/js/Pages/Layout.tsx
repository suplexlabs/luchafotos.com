import React from 'react'

interface LayoutProps {
    children: any
}

export default function Layout({ children }: LayoutProps) {
    return (
        <main>{children}</main>
    )
}
