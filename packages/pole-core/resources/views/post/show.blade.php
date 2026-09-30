@extends( 'pole-core::layouts.website' )

@section( 'content' )
    <section style="border: 4px solid #ec4899;">
        <span>{{ $post->publication_date->format( 'd/m/Y' ) }}</span>

        @if ( $post->tags->isNotEmpty() )
            <ul>
                @foreach ( $post->tags as $tag )
                    <li>{{ $tag->name }}</li>
                @endforeach
            </ul>
        @endif

        <h1>{{ $post->title }}</h1>

        @if ( $post->excerpt )
            <p>{{ $post->excerpt }}</p>
        @endif
    </section>

    @if ( $post->content )
        <section style="border: 4px solid #6b7280;">
            {!! $post->content !!}
        </section>
    @endif

    @if ( $latest_posts->isNotEmpty() )
        <section style="border: 4px solid #ec4899;">
            <h2>{{ __( 'Latest news' ) }}</h2>

            @foreach ( $latest_posts as $latest_post )
                @include( 'pole-core::post.card.classic', [ 'post' => $latest_post ] )
            @endforeach
        </section>
    @endif

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
