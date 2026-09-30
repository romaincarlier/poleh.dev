<?php
namespace Abacus\Filament\Pages;

use Abacus\Mail\Previewable;
use Abacus\Support\Discovery;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

use BackedEnum;

class Emails extends Page {
    protected string $view = 'abacus::filament.pages.emails';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-envelope';
    protected static ?int $navigationSort = 2;

    public string $current_class = '';
    public string $current_recipient = '';
    public string $current_html = '';

    public function mount() : void {
        $classes = $this->previewable_classes();

        $this->current_class = request()->input( 'template', array_key_first( $classes ) ?? '' );

        if ( ! array_key_exists( $this->current_class, $classes ) ) {
            $this->current_class = array_key_first( $classes ) ?? '';
        }

        $recipients = $this->current_class ? $this->current_class::preview_recipients() : [];

        $this->current_recipient = request()->input( 'recipient', array_key_first( $recipients ) ?? '' );

        if ( ! array_key_exists( $this->current_recipient, $recipients ) ) {
            $this->current_recipient = array_key_first( $recipients ) ?? '';
        }

        $this->current_html = $this->current_class ? self::preview( $this->current_class, $this->current_recipient ) : '';
    }

    public function previewable_classes() : array {
        $classes = [];

        foreach ( Discovery::classes_in( config( 'abacus.mailable_paths' ), Previewable::class ) as $class ) {
            $classes[ $class ] = $class::preview_label();
        }

        return $classes;
    }

    public static function preview( string $class, string $recipient ) : string {
        return ( new MailMessage() )
            ->subject( __( 'Test email' ) )
            ->markdown( $class::markdown_view( $recipient ), $class::preview_variables( $recipient ) )
            ->render()
            ->toString();
    }

    public static function getNavigationLabel() : string { return __( 'Email previews' ); }
    public static function getNavigationGroup() : string { return __( 'Settings' ); }
    public function getHeading() : string { return __( 'Email previews' ); }
    public function getSubheading() : string { return __( 'View and manage email previews for this application.' ); }

    protected function getHeaderActions() : array {
        return [
            Action::make( 'send_test_email' )
                ->label( __( 'Send test email' ) )
                ->icon( 'heroicon-o-paper-airplane' )
                ->schema( [
                    TextInput::make( 'email' )->label( __( 'Email address' ) )->email()->required(),

                    Select::make( 'template' )->label( __( 'Template' ) )->options( fn () => $this->previewable_classes() )->required()->live(),

                    Select::make( 'recipient' )
                        ->label( __( 'Recipient type' ) )
                        ->options( fn ( $get ) => $get( 'template' ) ? $get( 'template' )::preview_recipients() : [] )
                        ->required()
                ] )
                ->action( function ( array $data ) : void {
                    try {
                        Mail::send( [], [], function ( $message ) use ( $data ) : void {
                            $message->to( $data[ 'email' ] )
                                ->subject( __( 'Test email from :app', [ 'app' => config( 'app.name' ) ] ) )
                                ->html( self::preview( $data[ 'template' ], $data[ 'recipient' ] ) );
                        } );

                        Notification::make()->success()->title( __( 'Test email sent' ) )->send();
                    } catch ( \Throwable $exception ) {
                        Notification::make()->danger()->title( __( 'Error sending email' ) )->body( $exception->getMessage() )->send();
                    }
                } )
        ];
    }
}
