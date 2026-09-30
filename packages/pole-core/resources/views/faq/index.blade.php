@extends( 'pole-core::layouts.website' )

@section( 'content' )
    <section style="border: 4px solid #0d9488;">
        <h1>{{ __( 'Frequently asked questions' ) }}</h1>

        @forelse ( $glossaries as $glossary )
            <article>
                <h2><a href="{{ route( 'faq.show', $glossary ) }}">{{ $glossary->name }}</a></h2>

                @if ( $glossary->description )
                    <div>{!! Str::limit( $glossary->description, 120 ) !!}</div>
                @endif

                <a href="{{ route( 'faq.show', $glossary ) }}">
                    {{ __( 'See :count questions', [ 'count' => $glossary->questions_count ] ) }}
                </a>
            </article>
        @empty
            <p>{{ __( 'No frequently asked questions yet.' ) }}</p>
        @endforelse
    </section>

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
