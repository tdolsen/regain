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
     * @param regain\HTTP\Request &$request
     *
     * @return mixed
     */
    public function process_request(&$request) {}
    
    /**
     * Empty wrapper for process_response.
     *
     * @param regain\HTTP\Request  $request
     * @param regain\HTTP\Response &$response
     *
     * @return mixed
     */
    public function process_response($request, &$response) {}
}
