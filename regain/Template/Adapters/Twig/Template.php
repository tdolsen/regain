<?php

namespace regain\Template\Adapaters\Twig;

class Template extends \regain\Template\Template {
    protected $template;
    
    public function __construct($template) {
        $this->template = $template;
    }
    
    public function render($data) {
        if(!is_array($data)) $data = array();
        return $this->template->render($data);
    }
}