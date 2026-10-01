@extends( 'pole-core::layouts.website' )

@section( 'content' )
    <section style="border: 4px solid #0891b2;">
        <h1>{{ __( 'Plus tard je serai' ) }}</h1>
        <p>{{ __( 'Discover the jobs and career paths waiting for you in Hainaut.' ) }}</p>

        {{-- Hardcoded per plan.txt - the real presentation video isn't provided yet. --}}
        <div>{{ __( 'Presentation video' ) }}</div>
    </section>

    <section style="border: 4px solid #6366f1;">
        @forelse ( $sections as $section )
            <article>
                @if ( $section->background_image )
                    <img src="{{ asset( 'storage/' . $section->background_image ) }}" alt="">
                @endif

                <h2>{{ $section->name }}</h2>

                @if ( $section->excerpt )
                    <p>{{ $section->excerpt }}</p>
                @endif

                <a href="{{ route( 'ptjs.show', $section->route_parameters() ) }}" title="{{ __( 'Discover :name', [ 'name' => $section->name ] ) }}">
                    {{ __( 'Discover' ) }}
                </a>
            </article>
        @empty
            <p>{{ __( 'No sections published yet.' ) }}</p>
        @endforelse
    </section>

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
