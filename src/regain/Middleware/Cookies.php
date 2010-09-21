<?php

namespace regain\Middleware;

use regain\Middleware\MiddlewareAbstract
  , regain\HTTP\ResponseRedirect
  , regain\Settings
  ;

/**
 * A middleware class for handling cookies in a simpler and integrated way.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class Cookies extends MiddlewareAbstract {
    /**
     * Processes the request object and adds an instance of the CookieJar to it.
     *
     * @param regain\HTTP\Request $request
     *
     * @return regain\HTTP\Request
     */
    public function process_request($request) {
        $request->cookies = new CookieJar();
        return $request;
    }
    
    /**
     * Processe the response object. Destroys the CookieJar to send headers.
     *
     * @param regain\HTTP\Request $request
     * @param regain\HTTP\Response $response
     *
     * @return regain\HTTP\Response
     */
    public function _process_response($request, $response) {
        unset($request->cookies);
        return $response;
    }
}

/**
 * The cookie class used by the middleware. It keeps track of all cookies
 * set during a request, and sends them at request.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class CookieJar {
    /**
     * This is the old cookies sent from the client. These are read-only, but
     * new and updated cookies will be reflected here too.
     *
     * @var cookies array
     */
    private $cookies = array();
    
    /**
     * This is the new dough, ready for shipment to the client.
     *
     * @var dough array
     */
    private $dough = array();
    
    /**
     * Sets up the cookie jar, and fills it with delicious cookies.
     *
     * @return mixed
     */
    public function __construct() {
        $this->cookies = $_COOKIE;
    }
    
    /**
     * Makes it easy to access the cookie jar.
     * 
     * @param string $name The name of the cookie to find in the cookie jar
     * 
     * @return mixed
     */
    public function __get($name) {
        // TODO: Exception when not found?
        return $this->cookies[$name];
    }
    
    /**
     * Checks for a cookie in the cookie jar.
     *
     * @param string $name The cookie to look up
     *
     * @return boolean True if the cookie exists
     */
    public function __isset($name) {
        return isset($this->cookies[$name]);
    }
    
    /**
     * Makes it easy to add new cookies to the cookie jar. These cookies will
     * only be session cookies, using standard PHP fallbacks for all parameters
     * except the name and value.
     *
     * @param string $name  The cookie name
     * @param string $value The cookie value
     *
     * @return null
     */
    public function __set($name, $value) {
        $this->set($name, $value);
    }
    
    /**
     * Removes a cookie from the cookie jar, and sends a cookie with a negative
     * expiration time and same name.
     *
     * @param string $name The cookie set for deletion
     *
     * @return null
     */
    public function __unset($name) {
        unset($this->cookies[$name]);
        unset($this->dough[$name]);
        $this->set($name, '', time()-36000);
    }
    
    /**
     * The only way to create cookies. Well not the only, but at least one of them.
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
    public function set($name, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false) {
        $this->cookies[$name] = $value;
        $this->dough[] = array($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
    
    /**
     * It's such a good cookie jar that we have to destroy it to get it open and
     * send those cookies.
     *
     * @return null
     */
    public function __destruct() {
        foreach($this->dough as $dough) {
            call_user_func_array('set_cookie', $dough);
        }
    }
}