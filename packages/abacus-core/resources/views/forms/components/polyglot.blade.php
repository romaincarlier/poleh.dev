@php
    $locales = $get_locales();
    $isSingleLocale = count( $locales ) === 1;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @if ( $isSingleLocale )
        {{ $get_locale_schema( array_key_first( $locales ) ) }}
    @else
        <div
            x-data="{ locale: '{{ array_key_first( $locales ) }}' }"
            class="fi-abacus-polyglot"
        >
            <div class="flex gap-x-1 mb-2">
                @foreach ( $locales as $code => $label )
                    <button
                        type="button"
                        x-on:click="locale = '{{ $code }}'"
                        x-bind:class="locale === '{{ $code }}' ? 'fi-badge bg-primary-50 text-primary-600 ring-primary-600/10 dark:bg-primary-400/10 dark:text-primary-400' : 'fi-badge bg-gray-50 text-gray-600 ring-gray-500/10 dark:bg-gray-400/10 dark:text-gray-400'"
                        class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 py-1"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            @foreach ( $locales as $code => $label )
                <div x-show="locale === '{{ $code }}'" x-cloak>
                    {{ $get_locale_schema( $code ) }}
                </div>
            @endforeach
        </div>
    @endif
</x-dynamic-component>
