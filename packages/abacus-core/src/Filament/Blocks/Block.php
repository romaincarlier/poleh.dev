<?php
namespace Abacus\Filament\Blocks;

use Filament\Forms\Components\RichEditor\RichContentCustomBlock;

use Illuminate\Support\Str;

abstract class Block extends RichContentCustomBlock {
    public static function getId() : string {
        return Str::kebab( class_basename( static::class ) );
    }

    public static function toHtml( array $config, array $data ) : ?string {
        return view( 'filament.block.' . static::getId() . '.render', compact( 'config', 'data' ) )->render();
    }

    public static function toPreviewHtml( array $config ) : ?string {
        return view( 'filament.block.' . static::getId() . '.preview', compact( 'config' ) )->render();
    }
}
