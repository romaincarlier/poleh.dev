<?php
namespace Abacus\Support\Seo;

class Data {
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?string $keywords = null,
        public ?string $robots = null,
        public ?string $opengraph_title = null,
        public ?string $opengraph_description = null,
        public ?string $opengraph_image = null,
        public ?string $url = null
    ) {}

    public static function from_array( array $data ) : static {
        return new static(
            title: $data[ 'title' ] ?? null,
            description: $data[ 'description' ] ?? null,
            keywords: $data[ 'keywords' ] ?? null,
            robots: $data[ 'robots' ] ?? null,
            opengraph_title: $data[ 'opengraph_title' ] ?? null,
            opengraph_description: $data[ 'opengraph_description' ] ?? null,
            opengraph_image: $data[ 'opengraph_image' ] ?? null,
            url: $data[ 'url' ] ?? null
        );
    }

    // Fills every null property of this instance from the lower-priority tier.
    public function merge( self $lower_priority ) : static {
        return new static(
            title: $this->title ?? $lower_priority->title,
            description: $this->description ?? $lower_priority->description,
            keywords: $this->keywords ?? $lower_priority->keywords,
            robots: $this->robots ?? $lower_priority->robots,
            opengraph_title: $this->opengraph_title ?? $lower_priority->opengraph_title,
            opengraph_description: $this->opengraph_description ?? $lower_priority->opengraph_description,
            opengraph_image: $this->opengraph_image ?? $lower_priority->opengraph_image,
            url: $this->url ?? $lower_priority->url
        );
    }
}
