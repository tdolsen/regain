<?php

namespace regain\Template\Adapaters\Twig;

class Engine extends \regain\Template\Engine {
    protected $twig;
    
    public function __construct($settings) {
        $loader = new Twig_Loader_Filesystem($settings->template_path);
        $this->twig = new Twig_Environment($loader, array(
            'debug' => $settings->debug,
            'cahrset' => $settings->charset,
        ));
    }
    
    public function load_template($template) {
        
    }
}