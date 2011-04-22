<?php

namespace regain\Template\Adapters\PHP;

use regain\Template\TemplateAbstract;

class Template extends TemplateAbstract {
    protected $template;
    
    public function __construct($settings, $template) {
        if(substr($template, -4) == '.php') {
            $template = substr($template, 0, -4);
        }
        
        foreach($settings['template_paths'] as $path) {
            if(file_exists($path . $template)) {
                $this->template = $path . $template;
                break;
            }
        }
        
        if(empty($this->template)) {
            throw new \RuntimeException();
        }
    }
    
    public function render($data) {
        if(!is_array($data)) $data = array();
        
        ob_start();
        
        extract($data);
        
        include $this->template;
        
        return ob_get_clean();
    }
}