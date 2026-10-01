@extends( 'pole-core::layouts.website' )

@section( 'content' )
    <nav>
        @foreach ( $crumbs as $crumb )
            <a href="{{ $crumb[ 'url' ] }}">{{ $crumb[ 'title' ] }}</a>
        @endforeach
    </nav>

    <section style="border: 4px solid #0891b2; {{ $section->background_image ? 'background-image: url(' . asset( 'storage/' . $section->background_image ) . ')' : '' }}">
        <h1>{{ $section->name }}</h1>

        @if ( $section->excerpt )
            <p>{{ $section->excerpt }}</p>
        @endif

        @if ( ! empty( $section->jobs ) )
            <ul>
                @foreach ( $section->jobs as $job )
                    <li>{{ $job }}</li>
                @endforeach
            </ul>
        @endif
    </section>

    @if ( $section->youtube_id )
        <section style="border: 4px solid #6b7280;" data-ptjs-player data-video-id="{{ $section->youtube_id }}">
            <div data-ptjs-facade style="background-image: url('https://img.youtube.com/vi/{{ $section->youtube_id }}/hqdefault.jpg');">
                <button type="button" data-ptjs-play>{{ __( 'Play the video' ) }}</button>
            </div>

            <div data-ptjs-frame></div>

            @if ( ! empty( $section->chapters ) )
                <ul>
                    @foreach ( $section->chapters as $chapter )
                        <li>
                            <button type="button" data-ptjs-chapter data-timestamp="{{ $chapter[ 'timestamp' ] ?? 0 }}">
                                {{ data_get( $chapter, 'title.' . app()->getLocale() ) }}
                            </button>

                            @if ( ! empty( $chapter[ 'description' ] ) )
                                <p>{{ $chapter[ 'description' ] }}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        @once
            <script src="https://www.youtube.com/iframe_api"></script>
            <script>
                window.ptjsPlayers = window.ptjsPlayers || {};

                function onYouTubeIframeAPIReady() {
                    document.querySelectorAll( '[data-ptjs-player]' ).forEach( function ( container ) {
                        var videoId = container.dataset.videoId;

                        var createPlayer = function () {
                            if ( window.ptjsPlayers[ videoId ] ) {
                                return;
                            }

                            var frame = document.createElement( 'div' );
                            container.querySelector( '[data-ptjs-frame]' ).appendChild( frame );
                            container.querySelector( '[data-ptjs-facade]' ).style.display = 'none';

                            window.ptjsPlayers[ videoId ] = new YT.Player( frame, {
                                videoId: videoId,
                                events: {
                                    onReady: function ( event ) {
                                        event.target.playVideo();
                                    }
                                }
                            } );
                        };

                        container.querySelector( '[data-ptjs-play]' ).addEventListener( 'click', createPlayer );

                        container.querySelectorAll( '[data-ptjs-chapter]' ).forEach( function ( button ) {
                            button.addEventListener( 'click', function () {
                                createPlayer();

                                var player = window.ptjsPlayers[ videoId ];
                                var timestamp = parseInt( button.dataset.timestamp, 10 ) || 0;

                                if ( player && player.seekTo ) {
                                    player.seekTo( timestamp, true );
                                    player.playVideo();
                                }
                            } );
                        } );
                    } );
                }
            </script>
        @endonce
    @endif

    @if ( $section->description )
        <section style="border: 4px solid #9ca3af;">
            {!! $section->description !!}
        </section>
    @endif

    <x-pole-ptjs::sections.listing :except="$section" />

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
