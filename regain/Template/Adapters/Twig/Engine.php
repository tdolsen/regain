<?php

namespace regain\Template\Adapters\Twig;

use regain\Template\Adapters\Twig\Template;

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
        try {
            return new Template($this->twig->loadTemplate($template));
        } catch(\RuntimeException $e) {
            throw new TemplateImportException('Could not load template "' . $template . '". File not found in system.');
        }
    }
}