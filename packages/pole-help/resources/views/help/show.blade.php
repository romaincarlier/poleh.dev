@extends( 'pole-core::layouts.website' )

@section( 'content' )
    <nav>
        @foreach ( $crumbs as $crumb )
            <a href="{{ $crumb[ 'url' ] }}">{{ $crumb[ 'title' ] }}</a>
        @endforeach
    </nav>

    <section style="border: 4px solid #0d9488; {{ $category->background_image ? 'background-image: url(' . asset( 'storage/' . $category->background_image ) . ')' : '' }}">
        <h1>{{ $category->name }}</h1>

        @if ( $category->excerpt )
            <p>{{ $category->excerpt }}</p>
        @endif
    </section>

    <section style="border: 4px solid #6b7280;">
        @forelse ( $children as $child )
            <article>
                <h2>{{ $child->name }}</h2>

                @if ( $child->excerpt )
                    <p>{{ $child->excerpt }}</p>
                @endif

                <p>{{ trans_choice( ':count resource|:count resources', count( $child->resources ?? [] ), [ 'count' => count( $child->resources ?? [] ) ] ) }}</p>

                @if ( ! empty( $child->resources ) )
                    <ul>
                        @foreach ( $child->resources as $resource )
                            <li>
                                @if ( ! empty( $resource[ 'url' ] ) )
                                    <a href="{{ $resource[ 'url' ] }}">{{ $resource[ 'title' ] }}</a>
                                @else
                                    {{ $resource[ 'title' ] }}
                                @endif

                                @if ( ! empty( $resource[ 'description' ] ) )
                                    <p>{{ $resource[ 'description' ] }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </article>
        @empty
            <p>{{ __( 'No sub-categories yet.' ) }}</p>
        @endforelse
    </section>

    @if ( $category->description )
        <section style="border: 4px solid #9ca3af;">
            {!! $category->description !!}
        </section>
    @endif

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
