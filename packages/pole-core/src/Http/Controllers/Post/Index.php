<?php
namespace Modules\Pole\Core\Http\Controllers\Post;

use Abacus\Http\Controllers\Controller;
use Modules\Pole\Core\Models\Post as PostModel;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class Index extends Controller {
    protected static array $seo = [ 'title' => 'News' ];

    public function __invoke() : View {
        $this->crumb( route( 'post.index' ), __( 'News' ) );

        return $this->view( 'pole-core::post.index', [
            'posts' => $this->posts()
        ] );
    }

    protected function posts() : LengthAwarePaginator {
        return PostModel::where( 'is_published', true )
            ->orderByDesc( 'published_at' )
            ->orderByDesc( 'created_at' )
            ->paginate( 8 );
    }
}
