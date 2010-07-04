<?php

namespace regain\Middleware;

abstract class Base {
    public function __construct($settings) {}
    public function process_request(&$request) { return null; }
    public function process_response($request, &$response) { return null; }
}
