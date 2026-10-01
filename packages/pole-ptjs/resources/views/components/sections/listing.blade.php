<section style="border: 4px solid #6366f1;">
    <h2>{{ __( 'Other career paths' ) }}</h2>

    @foreach ( $sections as $other )
        <article>
            <h3>{{ $other->name }}</h3>
            <a href="{{ route( 'ptjs.show', $other->route_parameters() ) }}">{{ __( 'Discover' ) }}</a>
        </article>
    @endforeach
</section>
