@extends( 'pole-core::layouts.website' )

@section( 'content' )
    <section style="border: 4px solid #0d9488;">
        <a href="{{ route( 'faq.index' ) }}">{{ __( 'Back to frequently asked questions' ) }}</a>

        <h1>{{ $glossary->name }}</h1>

        @if ( $glossary->description )
            <div>{!! $glossary->description !!}</div>
        @endif

        @forelse ( $glossary->questions as $question )
            <details>
                <summary>{{ $question->question }}</summary>

                <div>{!! $question->answer !!}</div>
            </details>
        @empty
            <p>{{ __( 'No questions yet.' ) }}</p>
        @endforelse
    </section>

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
