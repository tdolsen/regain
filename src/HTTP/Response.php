<?php

namespace regain\HTTP;

class Response {
    protected $body;
    protected $status;
    protected $headers;

    public function __construct($body, $status=null, $headers=null) {
        if(is_array($status) and !isset($headers)) {
            $headers = $status;
            $status = null;
        }

        if(!isset($status)) {
            $status = 200;
        }

        $this->body = $body;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function __toString() {
//TODO: Make this work and flexible
//        foreach($this->headers as $header => $value) {
//            header($header . ": " . $value);
//        }

        return $this->body;
    }
}
