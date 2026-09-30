<?php
namespace Abacus\Http\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

// Signals a link/slug that used to resolve to real content but no longer does (found in a
// model's slug_history rather than truly never having existed) - what plan.txt calls "219
// expired". Wire this up in bootstrap/app.php's withExceptions() to redirect to the 404 page
// with a message a non-technical visitor can actually understand.
class Expired extends HttpException {
    public function __construct( string $message = '' ) {
        parent::__construct( 410, $message ?: 'This page or link has expired.' );
    }
}
