<?php

namespace regain\Template\Adapters\PHP;

use regain\Template\EngineInterface
  , regain\Template\Adapters\PHP\Template
  , regain\Exceptions\TemplateImportException
  , regain\Exceptions\TemplateSyntaxException
  ;

class Engine implements EngineInterface {
    protected $settings;

    public function __construct($settings) {
        $this->settings = $settings;
    }

    public function load_template($template) {
        try {
            return new Template($this->settings, $template);
        } catch(\RuntimeException $e) {
            throw new TemplateImportException('Could not load template "' . $template . '". File not found in system.');
        }
    }
}
