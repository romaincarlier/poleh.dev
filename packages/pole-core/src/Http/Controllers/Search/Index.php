<?php
namespace Modules\Pole\Core\Http\Controllers\Search;

use Abacus\Http\Controllers\Controller;
use Modules\Pole\Core\Models\Event;
use Modules\Pole\Core\Models\Glossary;
use Modules\Pole\Core\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Index extends Controller {
    protected static array $seo = [ 'title' => 'Search' ];

    protected static int $minimum_term_length = 3;
    protected static int $per_page = 10;

    public function __invoke( Request $request ) : View {
        $term = trim( (string) $request->input( 'search', '' ) );
        $filter = $request->input( 'filter', 'all' );

        $this->crumb( route( 'search.index' ), $term
            ? __( 'Search results for ":term"', [ 'term' => $term ] )
            : __( 'Search' ) );

        $error = $this->error_for( $term );
        $results = $error ? collect() : $this->results( $term, $filter );

        if ( ! $error && $results->isEmpty() ) {
            $error = __( 'No results found for your search term. Please try again with a different term.' );
        }

        return $this->view( 'pole-core::search.index', [
            'term' => $term,
            'error' => $error,
            'filters' => $this->filters( $term, $filter ),
            'current_filter' => $filter,
            'paginator' => $error ? null : $this->paginate( $results, $request )
        ] );
    }

    protected function error_for( string $term ) : ?string {
        if ( '' === $term ) {
            return __( 'Please enter a search term.' );
        }

        if ( Str::length( $term ) < static::$minimum_term_length ) {
            return __( 'Your search term is too short. Please enter at least :length characters.', [ 'length' => static::$minimum_term_length ] );
        }

        return null;
    }

    protected function filters( string $term, string $current ) : array {
        $filters = [
            'all' => __( 'All results' ),
            'event' => __( 'Agenda' ),
            'post' => __( 'News' ),
            'faq' => __( 'Frequently asked questions' )
        ];

        return collect( $filters )->map( fn ( $label, $key ) => [
            'label' => $label,
            'active' => $current === $key,
            'url' => route( 'search.index', [ 'search' => $term, 'filter' => $key ] )
        ] )->all();
    }

    protected function results( string $term, string $filter ) : Collection {
        $results = collect();

        if ( 'all' === $filter || 'event' === $filter ) {
            $results = $results->merge( $this->find_events( $term ) );
        }

        if ( 'all' === $filter || 'post' === $filter ) {
            $results = $results->merge( $this->find_posts( $term ) );
        }

        if ( 'all' === $filter || 'faq' === $filter ) {
            $results = $results->merge( $this->find_glossaries( $term ) );
        }

        return $results;
    }

    protected function find_events( string $term ) : Collection {
        return Event::query()
            ->where( fn ( $query ) => $query->where( 'name', 'like', "%{$term}%" )->orWhere( 'excerpt', 'like', "%{$term}%" ) )
            ->get()
            ->map( fn ( Event $event ) => [
                'title' => $event->name,
                'content' => $event->excerpt,
                'url' => route( 'event.show', $event->route_parameters() ),
                'type' => __( 'Event' ),
                'date' => $event->created_at->format( 'Y-m-d' )
            ] );
    }

    protected function find_posts( string $term ) : Collection {
        return Post::where( 'is_published', true )
            ->where( fn ( $query ) => $query->where( 'title', 'like', "%{$term}%" )->orWhere( 'excerpt', 'like', "%{$term}%" ) )
            ->get()
            ->map( fn ( Post $post ) => [
                'title' => $post->title,
                'content' => $post->excerpt,
                'url' => route( 'post.show', $post->route_parameters() ),
                'type' => __( 'News article' ),
                'date' => $post->publication_date->format( 'Y-m-d' )
            ] );
    }

    protected function find_glossaries( string $term ) : Collection {
        $locale = app()->getLocale();
        $needle = '%' . Str::lower( $term ) . '%';

        // JSON-extracted text carries a case-sensitive collation regardless of the column's own
        // collation, so a plain LIKE silently misses case differences unless both sides are lowered.
        return Glossary::query()
            ->whereRaw( "LOWER( JSON_UNQUOTE( JSON_EXTRACT( name, '$.\"{$locale}\"' ) ) ) LIKE ?", [ $needle ] )
            ->orWhereRaw( "LOWER( JSON_UNQUOTE( JSON_EXTRACT( description, '$.\"{$locale}\"' ) ) ) LIKE ?", [ $needle ] )
            ->get()
            ->map( fn ( Glossary $glossary ) => [
                'title' => $glossary->name,
                'content' => $glossary->description,
                'url' => route( 'faq.show', $glossary ),
                'type' => __( 'Frequently asked questions' ),
                'date' => $glossary->created_at->format( 'Y-m-d' )
            ] );
    }

    protected function paginate( Collection $results, Request $request ) : LengthAwarePaginator {
        $page = Paginator::resolveCurrentPage();
        $items = $results->forPage( $page, static::$per_page );

        return new LengthAwarePaginator(
            $items,
            $results->count(),
            static::$per_page,
            $page,
            [ 'path' => Paginator::resolveCurrentPath(), 'query' => $request->query() ]
        );
    }
}
