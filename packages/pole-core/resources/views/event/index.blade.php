@extends( 'poleh-core::layouts.website' )

@section( 'content' )
    <section style="border: 4px solid #a855f7;">
        <h1>{{ __( 'Agenda' ) }}</h1>

        @if ( $poster )
            @include( 'poleh-core::event.card.featured', [ 'event' => $poster ] )
        @endif

        @forelse ( $events as $event )
            @include( 'poleh-core::event.card.classic', [ 'event' => $event ] )
        @empty
            <p>{{ __( 'No upcoming events at the moment.' ) }}</p>
        @endforelse

        {{ $events->links() }}
    </section>

    <x-poleh-core::partners.listing />
    <x-poleh-core::call.help />
@endsection
