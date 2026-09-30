<?php
namespace Modules\PoleH\Core\View\Components;

use Illuminate\View\Component;

// Unstyled OpenStreetMap/Leaflet map, fixed to a given point - used on the contact page for the
// Pole hainuyer's own address (Avenue Frere Orban 9, 7000 Mons).
class Map extends Component {
    public function __construct(
        public float $latitude = 50.4508346,
        public float $longitude = 3.9565624,
        public int $zoom = 16
    ) {}

    public function render() {
        return view( 'poleh-core::components.map' );
    }
}
