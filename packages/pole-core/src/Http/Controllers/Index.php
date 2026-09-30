<?php
namespace Modules\Pole\Core\Http\Controllers;

use Abacus\Http\Controllers\Controller;
use Modules\Pole\Core\Models\Event;
use Modules\Pole\Core\Models\Post;
use Modules\Pole\Core\Settings\Homepage;

use Illuminate\View\View;

class Index extends Controller {
    protected static array $seo = [ 'title' => 'Home' ];

    public function __invoke() : View {
        $this->crumb( route( 'home' ), __( 'Home' ) );

        return $this->view( 'pole-core::index.home', [
            'settings' => app( Homepage::class ),
            'upcoming_events' => Event::where( 'event_date', '>=', now() )->orderBy( 'event_date' )->take( 4 )->get(),
            'latest_posts' => Post::where( 'is_published', true )->latest()->take( 4 )->get()
        ] );
    }
}
