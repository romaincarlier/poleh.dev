<section style="border: 4px solid #3b82f6;">
    @foreach ( $portals as $portal )
        <a href="{{ $portal[ 'url' ] }}" title="{{ $portal[ 'title' ] }}">
            <h3>{{ $portal[ 'title' ] }}</h3>
            <span>{{ __( 'Learn more' ) }}</span>
        </a>
    @endforeach
</section>
