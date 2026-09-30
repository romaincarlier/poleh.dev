<?php
namespace Abacus\Support\Seo;

class Data {
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?string $keywords = null,
        public ?string $robots = null,
        public ?string $og_title = null,
        public ?string $og_description = null,
        public ?string $og_image = null,
        public ?string $url = null
    ) {}

    public static function from_array( array $data ) : static {
        return new static(
            title: $data[ 'title' ] ?? null,
            description: $data[ 'description' ] ?? null,
            keywords: $data[ 'keywords' ] ?? null,
            robots: $data[ 'robots' ] ?? null,
            og_title: $data[ 'og_title' ] ?? null,
            og_description: $data[ 'og_description' ] ?? null,
            og_image: $data[ 'og_image' ] ?? null,
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
            og_title: $this->og_title ?? $lower_priority->og_title,
            og_description: $this->og_description ?? $lower_priority->og_description,
            og_image: $this->og_image ?? $lower_priority->og_image,
            url: $this->url ?? $lower_priority->url
        );
    }
}
