<?php
namespace Abacus\Support\Geocoding;

use Illuminate\Support\Facades\Http;

// Uses OpenStreetMap's public Nominatim endpoint - fine for a low-volume admin-only
// "Localize" button, but self-host or switch to a paid provider (LocationIQ, Geoapify)
// if this ever needs to run at any real volume: Nominatim's usage policy caps at
// roughly one request per second and disallows heavy/production use.
class Client {
    public function geocode( string $query ) : ?Coordinates {
        if ( empty( trim( $query ) ) ) {
            return null;
        }

        $response = Http::withHeaders( [ 'User-Agent' => config( 'app.name' ) . ' (' . config( 'app.url' ) . ')' ] )
            ->get( 'https://nominatim.openstreetmap.org/search', [
                'q' => $query,
                'format' => 'json',
                'limit' => 1
            ] );

        $result = $response->json( 0 );

        if ( empty( $result ) ) {
            return null;
        }

        return new Coordinates( (float) $result[ 'lat' ], (float) $result[ 'lon' ] );
    }
}
