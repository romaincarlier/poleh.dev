<details>
    <summary>{{ __( 'Search' ) }}</summary>

    <form action="{{ route( 'search.index' ) }}" method="GET">
        <input type="text" name="search" placeholder="{{ __( 'What are you looking for?' ) }}">
        <button type="submit">{{ __( 'Search' ) }}</button>
    </form>

    @if ( ! empty( $predefined_terms ) )
        <ul>
            @foreach ( $predefined_terms as $term )
                <li>
                    <a href="{{ route( 'search.index', [ 'search' => $term ] ) }}">{{ $term }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</details>
