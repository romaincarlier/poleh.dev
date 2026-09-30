<?php
namespace Modules\PoleH\Core\Mail;

use Abacus\Mail\Previewable;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable implements Previewable {
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $message
    ) {}

    public function envelope() : Envelope {
        return new Envelope( subject: __( 'New contact form submission' ) );
    }

    public function content() : Content {
        return new Content(
            markdown: static::markdown_view( 'administrator' ),
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'message' => $this->message
            ]
        );
    }

    public static function preview_label() : string {
        return __( 'Contact form' );
    }

    public static function preview_recipients() : array {
        return [ 'administrator' => __( 'Administrator' ) ];
    }

    public static function preview_variables( string $recipient ) : array {
        return [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => __( 'Test message to preview the email template. This can be safely ignored.' )
        ];
    }

    public static function markdown_view( string $recipient ) : string {
        return 'poleh-core::mail.contact.administrator';
    }
}
