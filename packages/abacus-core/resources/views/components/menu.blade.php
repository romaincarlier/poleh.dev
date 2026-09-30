@php
    $locale = app()->getLocale();
@endphp

<nav data-menu-position="{{ $position }}">
    <ul>
        @foreach ( $items as $item )
            <li>
                <a
                    href="{{ \Abacus\Menu\Models\Item::destination( $item ) }}"
                    @if ( $item->link_target ) target="{{ $item->link_target }}" @endif
                    @if ( $item->class ) class="{{ $item->class }}" @endif
                    title="{{ $item->link_title[ $locale ] ?? '' }}"
                >
                    {{ $item->label[ $locale ] ?? reset( $item->label ) }}
                </a>

                @if ( $item->children->isNotEmpty() )
                    <ul>
                        @foreach ( $item->children as $child )
                            <li>
                                <a href="{{ \Abacus\Menu\Models\Item::destination( $child ) }}">
                                    {{ $child->label[ $locale ] ?? reset( $child->label ) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
