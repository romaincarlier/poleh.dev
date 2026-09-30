<article>
    @if ( $post->media )
        <img src="{{ $post->media() }}" alt="">
    @endif

    <span>{{ $post->created_at->format( 'd/m/Y' ) }}</span>
    <h3>{{ $post->title }}</h3>

    {{-- posts-show is out of scope for this phase - link left as a placeholder --}}
    <a href="#">{{ __( 'Read more' ) }}</a>
</article>
