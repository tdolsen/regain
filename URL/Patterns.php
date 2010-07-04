<?php

namespace regain\URL;

class Patterns {
    protected $routes = array();

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
}
