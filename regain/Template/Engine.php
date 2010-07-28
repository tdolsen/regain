<?php

namespace regain\Template;

abstract class Engine {
    abstract public function __construct($settings);
    
    abstract public function load_template($template);
}