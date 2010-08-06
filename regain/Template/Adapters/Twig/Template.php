<?php

namespace regain\Template\Adapters\Twig;

use regain\Template\TemplateAbstract;

class Template extends TemplateAbstract {
    public function render($data) {
        if(!is_array($data)) $data = array();
        return $this->template->render($data);
    }
}