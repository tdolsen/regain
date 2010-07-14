<?php

namespace regain\HTTP;

class ResponseNotFound extends Response {
    public function __construct() {
        $this->status = 404;
        $this->body = "<h1>404 Not Found</h1>";
    }
}
