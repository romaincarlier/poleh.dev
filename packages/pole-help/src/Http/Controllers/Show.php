<?php
namespace Modules\Pole\Help\Http\Controllers;

use Modules\Pole\Help\Models\Resource\Category;

use Illuminate\View\View;

class Show extends Controller {
    public function __invoke( int $id, string $slug = '' ) : View {
        $category = Category::find_by_composed_slug_or_fail( $id, $slug );

        if ( $category->parent_id ) {
            abort( 404 );
        }

        $this->seo( $category, [ 'url' => route( 'help.show', $category->route_parameters() ) ] );
        $this->crumb( route( 'help.show', $category->route_parameters() ), $category->crumb_title() );

        return $this->view( 'pole-help::help.show', [
            'category' => $category,
            'children' => $category->children
        ] );
    }
}
