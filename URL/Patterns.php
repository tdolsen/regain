<?php

namespace regain\URL;

class Patterns implements \Iterator {
    protected $routes = array();
    protected $iterator = 0;

    public function __construct($patterns) {
        if(is_array($patterns)) {
            $this->add_routes($patterns);
        }
    }

    public function add_routes(array $routes) {
        foreach($routes as $regex => $view) {
            $this->add_route($regex, $view);
        }
    }

    public function add_route($regex, $view) {
        $this->routes[] = array($regex, $view);
    }

/* Iterator */
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
