@if ( ! empty( $result[ 'title' ] ) )
    <li>
        <article>
            <span>{{ $result[ 'type' ] }}</span>

            <h2><a href="{{ $result[ 'url' ] }}">{{ $result[ 'title' ] }}</a></h2>

            @if ( $result[ 'content' ] )
                <p>{{ Str::limit( strip_tags( $result[ 'content' ] ), 160 ) }}</p>
            @endif

            <a href="{{ $result[ 'url' ] }}">{{ __( 'Read more' ) }}</a>
        </article>
    </li>
@endif
