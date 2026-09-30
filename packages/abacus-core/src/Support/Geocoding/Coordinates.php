<?php
namespace Abacus\Support\Geocoding;

class Coordinates {
    public function __construct(
        public float $latitude,
        public float $longitude
    ) {}
}
