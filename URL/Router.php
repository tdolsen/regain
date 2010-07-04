<?php

namespace regain\URL;

class Router {
    protected $patterns;

    public function __construct($patterns) {
        $this->patterns = $patterns;
    }

    public function get_view($path) {
        foreach($this->patterns as $pattern) {
            $regex = '#' . str_replace('#', '\#', $pattern[0]) . '#';
            if(preg_match($regex, $path)) {
                $ret = $pattern[1];

                if($ret instanceof Patterns) {
                    // return $ret->get_view($path);
                    // TODO: Find a way to recursivly fetch the view, while sliceing off the sub path
                    throw new \regain\NotImplementedException();
                }

                return $ret;
            }
        }
    }
}
