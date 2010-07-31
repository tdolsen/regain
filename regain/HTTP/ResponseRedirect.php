<?php

namespace regain\HTTP;

/**
 * A wrapper class around regain\HTTP\Response for returning a 301 permanent
 * redirect HTTP status and sets the "Location" header to given string.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class ResponseRedirect extends Response {
    /**
     * The cunstructor function overriding the status, setting it to 301 and setting
     * the Location header.
     * 
     * @param string $redirect_to The URL which the client should be redirected to
     * 
     * @return null
     */
    public function __construct($redirect_to) {
        parent::__construct('');
        $this->status = 301;
        $this['Location'] = $redirect_to;
    }
}
