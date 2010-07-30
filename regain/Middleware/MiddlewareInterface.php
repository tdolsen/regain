<?php

namespace regain\Middleware;

interface MiddlewareInterface {
    public function process_request(&$request);
    public function process_response($request, &$response);
}
