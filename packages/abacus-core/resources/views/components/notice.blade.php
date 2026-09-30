@props( [ 'notice', 'should_show' ] )

@if ( $should_show )
    @php
        $locale = app()->getLocale();
    @endphp

    <div
        x-data="{ open: true }"
        x-show="open"
        x-cloak
        data-notice-type="{{ $notice->type }}"
    >
        @if ( $notice->image )
            <img src="{{ asset( 'storage/' . $notice->image ) }}" alt="">
        @endif

        <h2>{{ $notice->title[ $locale ] ?? reset( $notice->title ) }}</h2>

        <div>{!! $notice->text[ $locale ] ?? reset( $notice->text ) !!}</div>

        <button
            type="button"
            x-on:click="
                open = false;
                document.cookie = 'notice_dismissed=1; max-age=' + ( 60 * 60 * 24 * 7 ) + '; path=/';
            "
        >
            {{ __( 'Close' ) }}
        </button>
    </div>
@endif
