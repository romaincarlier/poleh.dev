<?php
namespace Modules\Pole\Core\Http\Controllers\Post;

use Abacus\Http\Controllers\Controller;
use Modules\Pole\Core\Models\Post as PostModel;

use Illuminate\View\View;

class Show extends Controller {
    public function __invoke( int $id, string $slug = '' ) : View {
        $post = PostModel::find_by_composed_slug_or_fail( $id, $slug );

        $this->seo( $post, [ 'url' => route( 'post.show', $post->route_parameters() ) ] );
        $this->crumb( route( 'post.index' ), __( 'News' ) );
        $this->crumb( route( 'post.show', $post->route_parameters() ), $post->crumb_title() );

        return $this->view( 'pole-core::post.show', [
            'post' => $post,
            'latest_posts' => PostModel::where( 'is_published', true )
                ->where( 'id', '!=', $post->id )
                ->orderByDesc( 'published_at' )
                ->orderByDesc( 'created_at' )
                ->take( 4 )
                ->get()
        ] );
    }
}
