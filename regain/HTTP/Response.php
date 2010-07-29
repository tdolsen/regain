<?php

namespace regain\HTTP;

class Response implements \ArrayAccess {
    protected $body;
    protected $headers;
    
    // TODO: Make a getter/setter around status to validate real http headers
    public $status;

    public function __construct($body, $status=null, $headers=null) {
        if(is_array($status) and !isset($headers)) {
            $headers = $status;
            $status = null;
        }

        if(!isset($status)) {
            $status = 200;
        }
        
        if(!is_array($headers)) {
            $headers = array();
        }

        $this->body = $body;
        $this->status = $status;
        $this->headers = $headers;
        
        $this->init();
    }
    
    // Runned after construct for initial setup of subclasses
    public function init() {}
    
    public function offsetExists($offset) {
        return isset($this->headers[$offset]);
    }
    
    public function offsetGet($offset) {
        return $this->headers[$offset];
    }
    
    public function offsetSet($offset, $value) {
        $this->headers[$offset] = $value;
    }
    
    public function offsetUnset($offset) {
        unset($this->headers[$offset]);
    }

    public function __toString() {
        // TODO: Take into account clients running HTTP/1.0
        // TODO: Complete this with code and textual representation of the status
        //header('HTTP/1.1 ' . $this->status . )
        
        // TODO: Make this better, safer, stronger, faster
        foreach($this->headers as $header => $value) {
            header($header . ": " . $value);
        }

        return $this->body;
    }
}
