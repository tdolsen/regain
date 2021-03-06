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
     * All new cookies get stored here, and sent to the browser on output.
     *
     * @var cookies array
     */
    protected $cookies = array();

    /**
     * An associative array representing additional headers to send. The index
     * is the header and the value is the.. well, the value.
     *
     * @var $headers array
     */
    protected $headers = array();

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
    public function __construct($body = null, $status = null, array $headers = null) {
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

    /**
     * The only way to create cookies. Well not the only, but at least one of them.
     * Basically only remaps to PHP's setcookie
     *
     * @param string  $name     The name of the cookie
     * @param string  $value    The value of the cookie as a string
     * @param integer $expire   A UNIX timestamp for when the cookie should expire
     * @param string  $path     The path the cookie will be availabke on
     * @param string  $domain   The domain the cookie should be available on
     * @param boolean $secure   True if cookie only can be sent over HTTPS
     * @param boolean $httponly True if cookie only can be accessed by a server
     *
     * @return boolean False if any problems occur
     */
    public function set_cookie($name, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false) {
        $this->cookies[$name] = array('value' => $value, 'expires' => $expire, 'path' => $path, 'domain' => $domain, 'secure' => $secure, 'httponly' => $httponly);
    }

    /**
     * The function making sure to output whatever is stored in the response.
     * Loops trough all headers, and sends the appropriate status code.
     *
     * @return string The content for outputting
     */
    public function __toString() {
        // TODO: Take into account clients running HTTP/1.0
        // TODO: Complete this with code and textual representation of the status
        header('HTTP/1.1 ' . $this->status);

        // TODO: This is a simple implementation for cookies. But is it enough?
        foreach($this->cookies as $key => $cookie) {
            $cookie = array_values($cookie);
            array_unshift($cookie, $key);

            call_user_func_array('setcookie', $cookie);
        }

        // TODO: Make this better, safer, stronger, faster
        foreach($this->headers as $header => $value) {
            header($header . ": " . $value);
        }

        return (string) $this->body;
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
