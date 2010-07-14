<?php

namespace regain;

use regain\Exceptions\TypeException
  , regain\Settings\Settings
  ;

class Template {
    protected $data;

    public function __construct($data) {
        if(isset($data) and !is_array($data)) {
            throw new TypeException('The data paramter must be an array.');
        }

        $this->data = $data;
    }

    public function render($template) {
        $template = ltrim($template, '/');

        ob_start();

        if(isset($this->data)) {
            extract($this->data);
        }

        $template_paths = Settings::get('template_paths');

        foreach($template_paths as $path) {
            if(!preg_match('/^(\.|\/|.{1}\:)/', $path)) {
                $path = './' . $path;
            }

            $file = rtrim($path, '/') . '/' . $template;

            if(file_exists($file)) {
                include $file;
                return ob_get_clean();
            }
        }

        try {
            \regain\_include($template);
            return ob_get_flush();
        } catch(IncludeException $e) {
            // TODO: Throw a custom TemplateIncludeException, for debug purposes
            throw $e;
        }
    }
}
