<?php
namespace Modules\PoleH\Core\Http\Controllers;

use Abacus\Http\Controllers\Controller;
use Modules\PoleH\Core\Models\Event;
use Modules\PoleH\Core\Models\Post;
use Modules\PoleH\Core\Settings\Homepage;

use Illuminate\View\View;

class Index extends Controller {
    protected static array $seo = [ 'title' => 'Home' ];

    public function __invoke() : View {
        $this->crumb( route( 'home' ), __( 'Home' ) );

        return $this->view( 'poleh-core::index.home', [
            'settings' => app( Homepage::class ),
            'upcoming_events' => Event::where( 'event_date', '>=', now() )->orderBy( 'event_date' )->take( 4 )->get(),
            'latest_posts' => Post::where( 'is_published', true )->latest()->take( 4 )->get()
        ] );
    }
}
