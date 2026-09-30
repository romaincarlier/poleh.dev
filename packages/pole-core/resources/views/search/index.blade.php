@extends( 'pole-core::layouts.website' )

@section( 'content' )
    <section style="border: 4px solid #64748b;">
        <h1>{{ $term ? __( 'Search results for ":term"', [ 'term' => $term ] ) : __( 'Search' ) }}</h1>

        @if ( $error )
            <p>{{ $error }}</p>
        @else
            <nav>
                <ul>
                    @foreach ( $filters as $key => $filter )
                        <li>
                            <a href="{{ $filter[ 'url' ] }}" @if ( $filter[ 'active' ] ) aria-current="true" @endif>
                                {{ $filter[ 'label' ] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <p>{{ __( ':count results found', [ 'count' => $paginator->total() ] ) }}</p>

            <ol>
                @foreach ( $paginator as $result )
                    @include( 'pole-core::search.result', [ 'result' => $result ] )
                @endforeach
            </ol>

            {{ $paginator->links() }}
        @endif
    </section>

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
