<article>
    @if ( $post->media )
        <img src="{{ $post->media() }}" alt="">
    @endif

    <h2>{{ $post->title }}</h2>

    @if ( $post->excerpt )
        <p>{{ $post->excerpt }}</p>
    @endif

    <a href="{{ route( 'post.show', $post->route_parameters() ) }}">{{ __( 'Read more' ) }}</a>
</article>
