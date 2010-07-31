<?php

namespace regain\HTTP;

use ArrayAccess;

/**
 * The regain response object used for outputting information to the browser.
 * The regain framework requires all responses to be an instance of this object.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class Response implements ArrayAccess {
    /**
     * A string representation of the content to be ouputted to the browser.
     *
     * @var $body string
     */
    protected $body;
    
    /**
     * An associative array representing additional headers to send. The index
     * is the header and the value is the.. well, the value.
     *
     * @var $headers array
     */
    protected $headers;
    
    /**
     * A variable holding the HTTP status.
     *
     * @var $status integer
     */
    public $status;
    // TODO: Make a getter/setter around status to validate real http headers
    
    /**
     * The standard constructor for making a response object.
     *
     * @param string $body    The body part of the HTTP response. Could also be
     *                        object, as long as it can be cast as string
     * @param integer $status The HTTP status to be return with the response.
     *                        If status is null, assumes it's OK and sets it to 200
     * @param array $headers  A associative array representing headers and their value
     *
     * @return null
     */
    public function __construct(string $body, integer $status=null, array $headers=null) {
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
    
    /* ArrayAccess */
    // TODO: Again, should I write documentation for these?
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
}
