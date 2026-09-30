<x-filament-panels::page>
    @if ( empty( $this->previewable_classes() ) )
        <p>{{ __( 'No previewable emails yet.' ) }}</p>
    @else
        <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; overflow: auto;">
            {!! $current_html !!}
        </div>
    @endif
</x-filament-panels::page>
