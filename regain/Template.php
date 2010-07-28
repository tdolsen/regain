<?php

namespace regain;

use regain\Settings;

class Template {
    static protected $engine;
    
    protected $template;

    public function __construct($template) {
        if(!isset($this->engine)) {
            $settings = new Settings();
            $engine = $settings->get('template_engine');
            self::$engine = new $engine($settings);
        }
        
        $this->template = self::$engine->load_template(ltrim($template, '/'));
    }

    public function render($data) {
        return $this->template->render($data);
    }
}