<?php

namespace regain\Middleware;

abstract class Base implements Skeleton {
    public function process_request(&$request) {}
    public function process_response($request, &$response) {}
}
