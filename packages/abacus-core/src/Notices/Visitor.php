<?php
namespace Abacus\Notices;

use Abacus\Settings\Notice;

class Visitor {
    public function should_show( Notice $notice ) : bool {
        if ( ! $notice->is_active || ! $notice->is_shown_by_default ) {
            return false;
        }

        return ! request()->cookie( 'notice_dismissed' );
    }

    public function mark_displayed() : void {
        cookie()->queue( 'notice_dismissed', '1', 7 * 24 * 60 );
    }
}
