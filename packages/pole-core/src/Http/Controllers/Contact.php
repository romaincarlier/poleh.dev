<?php
namespace Modules\Pole\Core\Http\Controllers;

use Abacus\Http\Controllers\Controller;
use Abacus\Settings\Email;
use Abacus\Settings\General;
use Modules\Pole\Core\Mail\ContactFormSubmitted;
use Modules\Pole\Core\Models\Employee;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class Contact extends Controller {
    protected static array $seo = [ 'title' => 'Contact us' ];

    public function index() : View {
        $this->crumb( route( 'contact.index' ), __( 'Contact us' ) );

        return $this->view( 'pole-core::contact.index', [
            'employees' => Employee::orderBy( 'order' )->get()
        ] );
    }

    public function store( Request $request ) : RedirectResponse {
        $data = $request->validate( [
            'name' => [ 'required', 'string', 'max:255' ],
            'email' => [ 'required', 'email', 'max:255' ],
            'message' => [ 'required', 'string', 'max:5000' ]
        ] );

        if ( ! app( Email::class )->is_sending_disabled ) {
            Mail::to( app( General::class )->contact_email ?: config( 'mail.from.address' ) )
                ->send( new ContactFormSubmitted( $data[ 'name' ], $data[ 'email' ], $data[ 'message' ] ) );
        }

        return back()->with( 'notice', __( 'Thank you, your message has been sent. We will get back to you as soon as possible.' ) );
    }
}
