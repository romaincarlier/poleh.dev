@php
    $date = $event->event_date;
@endphp

<article>
    @if ( $date )
        <div>
            <span>{{ $date->format( 'd' ) }}</span>
            <span>{{ $date->translatedFormat( 'F' ) }}</span>
            <span>{{ $date->format( 'Y' ) }}</span>
        </div>
    @endif

    <h3>{{ $event->name }}</h3>
    <p>{{ $event->display_location }}</p>

    <a href="{{ route( 'event.show', $event->route_parameters() ) }}" title="{{ $event->name }}">{{ __( 'Details and registration' ) }}</a>
</article>
