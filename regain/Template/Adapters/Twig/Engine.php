<?php

namespace regain\Template\Adapters\Twig;

class Engine extends \regain\Template\Engine {
    protected $twig;
    
    public function __construct($settings) {
        $loader = new \Twig_Loader_Filesystem($settings->template_paths);
        $this->twig = new \Twig_Environment($loader, array(
            'debug' => $settings->debug,
            'cahrset' => $settings->charset,
        ));
    }
    
    public function load_template($template) {
        return $this->twig->loadTemplate($template);
    }
}