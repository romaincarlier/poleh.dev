@extends( 'pole-core::layouts.website' )

@section( 'content' )
    @php
        $locale = app()->getLocale();
    @endphp

    {{-- Slideshow --}}
    <section style="border: 4px solid #ef4444;">
        @foreach ( $settings->slides as $slide )
            <div>
                @if ( ! empty( $slide[ 'mobile_image' ] ) )
                    <picture>
                        <source media="(max-width: 640px)" srcset="{{ asset( 'storage/' . $slide[ 'mobile_image' ] ) }}">
                        <img src="{{ asset( 'storage/' . ( $slide[ 'image' ] ?? '' ) ) }}" alt="">
                    </picture>
                @elseif ( ! empty( $slide[ 'image' ] ) )
                    <img src="{{ asset( 'storage/' . $slide[ 'image' ] ) }}" alt="">
                @endif

                <h2>{{ $slide[ 'title' ] ?? '' }}</h2>
                <p>{{ $slide[ 'subtitle' ] ?? '' }}</p>

                @if ( ! empty( $slide[ 'outbound_link' ][ 'destination' ] ) )
                    <a href="{{ $slide[ 'outbound_link' ][ 'destination' ] }}" class="{{ $slide[ 'outbound_link' ][ 'class' ] ?? '' }}" title="{{ $slide[ 'outbound_link' ][ 'title' ] ?? '' }}">
                        {{ $slide[ 'outbound_link' ][ 'label' ] ?? __( 'Learn more' ) }}
                    </a>
                @endif
            </div>
        @endforeach
    </section>

    <x-pole-core::categories.portals />

    {{-- #plustardjeserai teaser, hardcoded --}}
    <section style="border: 4px solid #22c55e;">
        <h2>{{ __( '#plustardjeserai' ) }}</h2>
        <p>{{ __( 'What jobs are open to you after higher education?' ) }}</p>
        <p>{{ __( 'Discover a few careers that higher education leads to.' ) }}</p>
        <a href="#">{{ __( 'Browse job categories' ) }}</a>
    </section>

    {{-- Statistics, hardcoded --}}
    <section style="border: 4px solid #eab308;">
        <p>{{ __( 'The Pole hainuyer in a few numbers...' ) }}</p>

        @foreach ( [
            [ 'label' => __( 'Partner institutions' ), 'value' => '35' ],
            [ 'label' => __( 'Students' ), 'value' => '37 000' ],
            [ 'label' => __( 'Universities' ), 'value' => '3' ],
            [ 'label' => __( 'University colleges' ), 'value' => '3' ],
            [ 'label' => __( 'Art schools' ), 'value' => '3' ],
            [ 'label' => __( 'Adult education institutions' ), 'value' => '22' ]
        ] as $stat )
            <div>
                <strong>{{ $stat[ 'value' ] }}</strong>
                <span>{{ $stat[ 'label' ] }}</span>
            </div>
        @endforeach
    </section>

    {{-- Upcoming events - simple next-4 grid, featured/poster layout is core/event-index scope --}}
    <section style="border: 4px solid #a855f7;">
        <h2>{{ __( 'Upcoming events' ) }}</h2>

        @forelse ( $upcoming_events as $event )
            @include( 'pole-core::event.card.classic', [ 'event' => $event ] )
        @empty
            <p>{{ __( 'No upcoming events at the moment.' ) }}</p>
        @endforelse
    </section>

    {{-- Latest posts --}}
    <section style="border: 4px solid #ec4899;">
        <h2>{{ __( 'Latest news' ) }}</h2>

        @forelse ( $latest_posts as $post )
            @include( 'pole-core::post.card.classic', [ 'post' => $post ] )
        @empty
            <p>{{ __( 'No posts published yet.' ) }}</p>
        @endforelse
    </section>

    <x-pole-core::partners.listing />

    <x-pole-core::call.help />
@endsection
