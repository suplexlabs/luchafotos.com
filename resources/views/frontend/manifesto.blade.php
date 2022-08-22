@extends('layouts.base', [
    'title' => 'Our Manifesto'
])

@section('content')
    <x-structure.article>
        <x-slot:title>
            Our Manifesto
        </x-slot>
        <p>
            Why did I build <a href="https://www.thedailysmark.com">The Daily Smark</a>?
            <br />
            <br />
            Let's dive into that answer the best way possible... 👇🏽👇🏽👇🏽
        </p>
        <p>
            I always felt wrestling news was stuck in 90s. It was a simpler time where
            you came to the news and waited for it. Today that's all changed. No one
            waits to see the news. The news waits for us to consume it. I want to
            modernize it and bring it into 2020.
        </p>
        <p>
            The sad part is we're dealing with issues that we had in the 90s that have
            now exploded by 10 times. Ads & personal information tracking is at an all
            time high.
            <br />
            <br />
            Un-reliable and "plans changed" news is now a tweet away. Not many do the
            work anymore, they want the clicks instead.
        </p>
        <p>
            I want to level the playing field for everyone. We're in the perfect time
            for creativity in wrestling. We have amazing bloggers, podcasters,
            youtubers, etc that put out constant wrestling content. No one knows about
            them but I want to help put them in the public eye.
        </p>
        <p>
            We aren't there yet but it has a strong foundation. Daily it gets closer. If
            this thread sparks any interest then give me a follow, check out our website
            & app, tell a friend. We can build together for a better wrestling
            experience
        </p>
        <blockquote class="mx-auto mt-10">
            This manifesto was originally posted as
            <a
                target="_blank"
                href="https://twitter.com/thedailysmark/status/1294269847686307842"
                >twitter thread</a
            >
            and has been formatted for the website.
        </blockquote>
    </x-structure.article>
@endsection