@extends('layouts.base')

@section('content')
    <main>
        <article>
            <h1 class="text-center">500 - Something Broke!</h1>
            <div>
                <img
                    class="inline-block"
                    src="/img/500.gif"
                    alt="A gif of shocked fan watching Undertaker's streak being broken"
                />
                <figcaption>
                    <em>What else broke now!?</em>
                </figcaption>
                <div class="text-center mt-2">
                    <a
                        class="button"
                        href="https://www.twitter.com/thedailysmark"
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