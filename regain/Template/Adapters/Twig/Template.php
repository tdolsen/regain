<?php

namespace regain\Template\Adapaters\Twig;

class Template extends \regain\Template\Template {
    protected $template;
    
    public function __construct($template) {
        $this->template = $template;
    }
    
    public function render($data) {
        return $this->template->render($data);
    }
}