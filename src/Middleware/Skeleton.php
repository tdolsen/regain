<?php

namespace regain\Middleware;

interface Skeleton {
    public function process_request(&$request);
    public function process_response($request, &$response);
}
