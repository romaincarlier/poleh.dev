<?php
namespace Modules\Pole\Core\Http\Controllers\Event;

use Abacus\Http\Controllers\Controller;
use Modules\Pole\Core\Models\Event;
use Modules\Pole\Core\Models\Post;

use Illuminate\View\View;

class Show extends Controller {
    public function __invoke( int $id, string $slug = '' ) : View {
        $event = Event::find_by_composed_slug_or_fail( $id, $slug );

        $this->seo( $event, [ 'url' => route( 'event.show', $event->route_parameters() ) ] );
        $this->crumb( route( 'event.index' ), __( 'Agenda' ) );
        $this->crumb( route( 'event.show', $event->route_parameters() ), $event->crumb_title() );

        return $this->view( 'pole-core::event.show', [
            'event' => $event,
            'next_events' => Event::where( 'id', '!=', $event->id )
                ->where( 'event_date', '>=', now() )
                ->orderBy( 'event_date' )
                ->take( 3 )
                ->get(),
            'latest_posts' => Post::where( 'is_published', true )->latest()->take( 4 )->get()
        ] );
    }
}
