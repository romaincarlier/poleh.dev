<?php
namespace Modules\PoleH\Core\Http\Controllers\Event;

use Abacus\Http\Controllers\Controller;
use Modules\PoleH\Core\Models\Event;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class Index extends Controller {
    protected static array $seo = [ 'title' => 'Agenda' ];

    public function __invoke() : View {
        $this->crumb( route( 'event.index' ), __( 'Agenda' ) );

        $poster = Event::where( 'is_poster', true )->first();

        return $this->view( 'poleh-core::event.index', [
            'poster' => $poster,
            'events' => $this->upcoming_events( $poster )
        ] );
    }

    protected function upcoming_events( ?Event $poster ) : LengthAwarePaginator {
        return Event::query()
            ->when( $poster, fn ( $query ) => $query->where( 'id', '!=', $poster->id ) )
            ->orderBy( 'event_date' )
            ->paginate( 8 );
    }
}
