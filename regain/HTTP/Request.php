<?php

namespace regain\HTTP;

/**
 * The regain request object. Most applications will revolve around this object.
 * It represents all data sendt from the client, as well as some other useful
 * information.
 *
 * This object will in many cases be manipulated by middleware classes, and may
 * change significantly from application to application.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class Request {
    /**
     * An array accessible from magic {@link __get()} method. Contains all directly
     * accessable information.
     *
     * @var array
     */
    protected $data;
    
    /**
     * The constructor, setting up all basic information related to the request.
     *
     * @return null
     */
    public function __construct() {
        if(isset($_SERVER['PATH_INFO'])) {
            $uri = array(
                $_SERVER['PATH_INFO'],
                $_SERVER['QUERY_STRING']
            );
        } else {
            $uri = explode('?', $_SERVER['REQUEST_URI'], 2);
            if(strtolower(substr($uri[0], 0, 10)) == '/index.php') $uri[0] = substr($uri[0], 10);
            if(count($uri) < 2) $uri[1] = '';
        }
        
        $data = array(
            'path' => ltrim($uri[0], '/'),
            'query_string' => $_SERVER['QUERY_STRING'],
            'method' => $_SERVER['REQUEST_METHOD'],
            'get' => $_GET,
            'post' => $_POST,
            'meta' => $_SERVER
        );
        
        $this->data = $data;
    }
    
    /**
     * Magic __get method for accessing {@link $data}.
     *
     * @param string $key The index to lookup in the data array
     *
     * @return mixed Returns the value of the data requested
     */
    public function __get($key) {
        // TODO: Maybe throw some exceptions if key is unset
        return $this->data[$key];
    }
    
    /**
     * Magic __isset method.
     *
     * @param string $key The index to lookup
     *
     * @return boolean
     */
    public function __isset($key) {
        return isset($this->data[$key]);
    }
    
    /**
     * Magic __set method for adding attiontion information to the data array.
     *
     * @param string $key The index to set
     * @param mixed  $value The information to set
     *
     * @return null
     */
    public function __set($key, $value) {
        // TODO: Maybe setup some variables that are read-only, and throw exceptions when setting them
        $this->data[$key] = $value;
    }
    
    /**
     * Should return the hostname for the current request.
     *
     * Currently only throws an NotImplementedException.
     */
    public function get_host() {
        throw new \regain\NotImplementedException();
    }
    
    /**
     * Returns the request URI. However, it seems like there is something wrong.
     *
     * @return string The request URI for the current request
     */
    public function get_full_path() {
        return $this->meta['REQUEST_URI'];
    }
    
    /**
     * A method for checking if the request is called with ajax.
     *
     * Most ajax libraries makes sure the needed header is set, but if it don't
     * one would have to set the HTTP_X_REQUESTED_WITH header to 'XMLHttpRequest'.
     *
     * @return boolean True if request is ajax, else false
     */
    public function is_ajax() {
        return (
                isset($this->meta['HTTP_X_REQUESTED_WITH'])
                and $this->meta['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
               );
    }
    
    /**
     * A method for checking wheter a request is sent over the HTTPS protocol.
     *
     * @return boolean True if request is secure, else false
     */
    public function is_secure() {
        return (
                isset($this->meta['HTTPS'])
                and $this->meta['HTTPS'] == 'on'
               );
    }
}