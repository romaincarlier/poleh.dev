@php
    $container_path = \Illuminate\Support\Str::beforeLast( $field->getStatePath(), '.' );
    $latitude_path = $container_path . '.' . $prefix . '_latitude';
    $longitude_path = $container_path . '.' . $prefix . '_longitude';
@endphp

<div
    wire:ignore
    x-data="{
        lat: $wire.entangle( '{{ $latitude_path }}' ),
        lng: $wire.entangle( '{{ $longitude_path }}' ),
        map: null,
        marker: null,
        init() {
            const start = [ this.lat || 50.45, this.lng || 4.86 ];

            this.map = L.map( this.$refs.map ).setView( start, this.lat ? 15 : 7 );

            L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            } ).addTo( this.map );

            this.marker = L.marker( start, { draggable: true } ).addTo( this.map );

            this.marker.on( 'dragend', () => {
                const position = this.marker.getLatLng();
                this.lat = position.lat;
                this.lng = position.lng;
            } );

            this.$watch( 'lat', () => this.sync() );
            this.$watch( 'lng', () => this.sync() );
        },
        sync() {
            if ( ! this.lat || ! this.lng ) {
                return;
            }

            this.marker.setLatLng( [ this.lat, this.lng ] );
            this.map.setView( [ this.lat, this.lng ] );
        }
    }"
>
    <div x-ref="map" style="height: 320px; border-radius: 0.5rem;"></div>
</div>
