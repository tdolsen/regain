<?php

namespace regain\Middleware;

/**
 * A simple wrapper arount regain\Middleware\MiddlewareInterface, so one dont't
 * have to define all methods. Basically does nothing else.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
abstract class MiddlewareAbstract implements MiddlewareInterface {
    /**
     * Empty wrapper for process_request.
     *
     * @param regain\HTTP\Request $request
     *
     * @return regain\HTTP\Request
     */
    public function process_request($request) {
        return $request;
    }
    
    /**
     * Empty wrapper for process_response.
     *
     * @param regain\HTTP\Request  $request
     * @param regain\HTTP\Response $response
     *
     * @return regain\HTTP\Response
     */
    public function process_response($request, $response) {
        return $response;
    }
}
