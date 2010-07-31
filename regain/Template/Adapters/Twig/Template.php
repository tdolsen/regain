<?php

namespace regain\Template\Adapters\Twig;

class Template extends \regain\Template\Template {
    public function render($data) {
        if(!is_array($data)) $data = array();
        return $this->template->render($data);
    }
}