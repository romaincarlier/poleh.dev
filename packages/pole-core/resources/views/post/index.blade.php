@extends( 'pole-core::layouts.website' )

@section( 'content' )
    <section style="border: 4px solid #ec4899;">
        <h1>{{ __( 'News' ) }}</h1>

        @forelse ( $posts as $post )
            @include( 'pole-core::post.card.large', [ 'post' => $post ] )
        @empty
            <p>{{ __( 'No posts published yet.' ) }}</p>
        @endforelse

        {{ $posts->links() }}
    </section>

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
