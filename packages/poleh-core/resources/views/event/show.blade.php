@extends( 'poleh-core::layouts.website' )

@section( 'content' )
    @php
        $date = $event->event_date;
    @endphp

    <section style="border: 4px solid #a855f7; {{ $event->image ? 'background-image: url(' . asset( 'storage/' . $event->image ) . ')' : '' }}">
        @if ( $date )
            <div>
                <span>{{ $date->format( 'd' ) }}</span>
                <span>{{ $date->translatedFormat( 'F' ) }}</span>
                <span>{{ $date->format( 'Y' ) }}</span>
            </div>
        @endif

        <h1>{{ $event->name }}</h1>

        @if ( $event->excerpt )
            <p>{{ $event->excerpt }}</p>
        @endif
    </section>

    <section style="border: 4px solid #eab308;">
        @if ( $event->human_date )
            <p>{{ $event->human_date }}</p>
        @elseif ( $date )
            <p>{{ $date->translatedFormat( 'd F Y' ) }}</p>
        @endif

        @if ( $event->display_location )
            <p>{{ $event->display_location }}</p>
        @endif

        @if ( $event->organizer_name )
            <p>{{ __( 'Organized by :name', [ 'name' => $event->organizer_name ] ) }}</p>
        @endif

        @if ( $event->price )
            <p>{{ __( 'Price' ) }}: {{ $event->price }} &euro;</p>
        @endif

        @if ( $event->registration_url )
            <a href="{{ $event->registration_url }}">{{ __( 'Registration' ) }}</a>
        @endif

        @if ( $event->info_url )
            <a href="{{ $event->info_url }}">{{ __( 'More information' ) }}</a>
        @endif

        @if ( $event->organizer_email )
            <a href="mailto:{{ $event->organizer_email }}">{{ __( 'Contact the organizer' ) }}</a>
        @endif
    </section>

    @if ( $event->description )
        <section style="border: 4px solid #6b7280;">
            {!! $event->description !!}
        </section>
    @endif

    @if ( $next_events->isNotEmpty() )
        <section style="border: 4px solid #22c55e;">
            <h2>{{ __( 'Other upcoming events' ) }}</h2>

            @foreach ( $next_events as $next_event )
                @include( 'poleh-core::event.card.classic', [ 'event' => $next_event ] )
            @endforeach
        </section>
    @endif

    @if ( $latest_posts->isNotEmpty() )
        <section style="border: 4px solid #ec4899;">
            <h2>{{ __( 'Latest news' ) }}</h2>

            @foreach ( $latest_posts as $post )
                @include( 'poleh-core::post.card.classic', [ 'post' => $post ] )
            @endforeach
        </section>
    @endif

    <x-poleh-core::partners.listing />
    <x-poleh-core::call.help />
@endsection
