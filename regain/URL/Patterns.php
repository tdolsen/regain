<?php

namespace regain\URL;

use regain\LazyUrlsLoader;

/**
 * The class handeling URL patterns for an application.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class Patterns implements \Iterator {
    /**
     * Keeps track of all routes
     * 
     * @var array
     */
    protected $routes = array();
    
    /**
     * Stores the counter for implementation of Iterator
     * 
     * @var integer
     */
    protected $iterator = 0;
    
    /**
     * The constructor. Takes an optional parameter for setting inital routes, and
     * passes it to {@link add_routes()}.
     *
     * @param array $patterns An associative array containing initial routes,
     *                        omits any behaviour if parameter is unset
     *
     * @return null
     */
    public function __construct(array $patterns = null) {
        if(is_array($patterns)) {
            $this->add_routes($patterns);
        }
    }
    
    /**
     * Adds an associative array of routes to the stack.
     *
     * @param array $routes The array containing the routes, defined as
     *                      array(regexp => route)
     *
     * @return $this
     */
    public function add_routes(array $routes) {
        foreach($routes as $regex => $view) {
            $this->add_route($regex, $view);
        }
        
        return $this;
    }
    
    /**
     * Adds a single route to the stack.
     *
     * @param string                     $regex A string representing a URL pattern
     *                                   to match
     * @param string|regain\URL\Patterns $view A string representing a view to load,
     *                                   or an instance of Patterns to search further on.
     *
     * @return $this
     */
    public function add_route(string $regex, $view) {
        $this->routes[] = array($regex, $view);
    }
    
    /**
     * A recursive method searching for matches in the patterns stack. If the view
     * defined for the pattern is an instance of regain\URL\Patterns, the method
     * searches that instance for matches, after it has removed the matched part.
     *
     * @param string $path The URL to match patterns up against
     *
     * @return string Returns the textual representation of the view function.
     */
    public function get_view(string $path) {
        foreach($this->routes as $route) {
            $regex = '#' . str_replace('#', '\#', $route[0]) . '#';
            if(preg_match($regex, $path)) {
                $ret = $route[1];

                if($ret instanceof LazyUrlsLoader) {
                    $ret = $ret->__load();
                }

                if($ret instanceof Patterns) {
                    $path = preg_replace($regex, '', $path);
                    return $ret->get_view($path);
                }

                return $ret;
            }
        }
    }

    /* Iterator */
    // TODO: Should these be documented? I'm still kind of new to that aspect of coding.
    public function current() {
        return $this->routes[$this->iterator];
    }

    public function key() {
        return $this->iterator;
    }

    public function next() {
        $this->iterator++;
    }

    public function rewind() {
        $this->iterator = 0;
    }

    public function valid() {
        return isset($this->routes[$this->iterator]);
    }
}
