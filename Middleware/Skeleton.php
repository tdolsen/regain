<?php

namespace regain\Middleware;

interface Skeleton {
    public function __construct($settings);
    public function process_request(&$request);
    public function process_response($request, &$response);
}
