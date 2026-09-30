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

    {{-- event-show is out of scope for this phase - link left as a placeholder --}}
    <a href="#">{{ __( 'Details and registration' ) }}</a>
</article>
