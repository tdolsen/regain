<?php

namespace regain\Middleware;

abstract class MiddlewareAbstract implements MiddlewareInterface {
    public function process_request(&$request) {}
    public function process_response($request, &$response) {}
}
