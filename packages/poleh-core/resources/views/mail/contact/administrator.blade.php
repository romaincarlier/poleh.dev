@component( 'mail::message' )
# {{ __( 'New contact form submission' ) }}

**{{ __( 'Name' ) }}:** {{ $name }}
**{{ __( 'Email' ) }}:** {{ $email }}

{{ $message }}
@endcomponent
