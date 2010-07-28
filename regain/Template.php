<?php

namespace regain;

use regain\Settings
  , regain\Exceptions\TemplateImportException;

class Template {
    static protected $engine;
    
    protected $template;

    public function __construct($template) {
        if(!isset($this->engine)) {
            $settings = new Settings();
            $engine = $settings->get('template_engine');
            self::$engine = new $engine($settings);
        }
        
        try {
            $this->template = self::$engine->load_template(ltrim($template, '/'));
        } catch(\RuntimeException $e) {
            throw new TemplateImportException('Could not load template "' . $template . '". File not found in system.');
        }
    }

    public function render($data) {
        if(!is_array($data)) $data = array();
        return $this->template->render($data);
    }
}