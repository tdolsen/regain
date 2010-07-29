<?php

namespace regain\HTTP;

class ResponseRedirect extends Response {
    public function __construct($redirect_to) {
        parent::__construct('');
        $this->status = 301;
        $this['Location'] = $redirect_to;
    }
}
