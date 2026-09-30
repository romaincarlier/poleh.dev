<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div
    x-data="{
        init() {
            const map = L.map( this.$refs.map ).setView( [ {{ $latitude }}, {{ $longitude }} ], {{ $zoom }} );

            L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            } ).addTo( map );

            L.marker( [ {{ $latitude }}, {{ $longitude }} ] ).addTo( map );
        }
    }"
>
    <div x-ref="map" style="height: 320px;"></div>
</div>
