<?php

namespace regain\HTTP;

/**
 * A wrapper class around regain\HTTP\Response for returning a 404 Not Found
 * HTTP response status.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class ResponseNotFound extends Response {
    /**
     * The cunstructor function overriding the status, calling parent constructor
     * with a 404 status code.
     *
     * @param string $body   A possible body to return
     * @param array $headers Additional headers to send
     *
     * @return null
     */
    public function __construct($body = null, array $headers = null) {
        if(!isset($body)) $body = '<h1>404 - Not Found</h1>';
        parent::__construct($body, 404, $headers);
    }
}
