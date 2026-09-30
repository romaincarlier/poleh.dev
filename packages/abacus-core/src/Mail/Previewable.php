<?php
namespace Abacus\Mail;

interface Previewable {
    public static function preview_label() : string;

    // Keyed by recipient identifier (e.g. 'administrator', 'user') => human label.
    public static function preview_recipients() : array;

    public static function preview_variables( string $recipient ) : array;

    public static function markdown_view( string $recipient ) : string;
}
