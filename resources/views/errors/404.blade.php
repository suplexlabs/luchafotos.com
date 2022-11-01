@extends('layouts.base')

@section('content')
    <main>
        <article>
            <h1 class="text-3xl text-center font-bold">
                404 - Page Not Found
            </h1>
            <div>
                <figure class="text-center">
                    <img
                        class="inline-block"
                        src="/img/404.gif"
                        alt="A gif of Sycho Sid screaming in agony on WCW Nitro."
                    />
                    <figcaption>
                        <em>
                            Sycho Sid can't believe you've found yourself lost with nowhere to
                            go!
                        </em>
                    </figcaption>
                </figure>
                <div class="text-center mt-2">
                    <a
                        class="button"
                        href="https://www.twitter.com/imperez"
                        target="_blank"
                        aria-label="twitter"
                    >
                        twitter</a
                    >
                </div>
            </div>
        </article>
    </main>
@endsection