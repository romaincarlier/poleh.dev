<section style="border: 4px solid #f97316;">
    <h2>{{ __( 'Partner institutions' ) }}</h2>

    @foreach ( $partners as $partner )
        <a href="{{ $partner->destination_url ?: '#' }}" title="{{ $partner->name }}">
            @if ( $partner->logo )
                <img src="{{ asset( 'storage/' . $partner->logo ) }}" alt="{{ $partner->name }}">
            @else
                {{ $partner->name }}
            @endif
        </a>
    @endforeach
</section>
