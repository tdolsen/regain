<?php

namespace regain\URL;

class Router {
    protected $patterns;

    public function __construct($patterns) {
        $this->patterns = $patterns;
    }

    public function get_view($path) {
        foreach($this->patterns as $pattern) {
            if($path == $pattern[0]) {
                return $pattern[1];
            } elseif(preg_match('#' . preg_quote($pattern[0], '#') . '#', $path)) {
                return $pattern[1];
            }
        }
    }
}
