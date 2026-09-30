<article>
    @if ( $post->media )
        <img src="{{ $post->media() }}" alt="">
    @endif

    <span>{{ $post->publication_date->format( 'd/m/Y' ) }}</span>
    <h3>{{ $post->title }}</h3>

    <a href="{{ route( 'post.show', $post->route_parameters() ) }}">{{ __( 'Read more' ) }}</a>
</article>
