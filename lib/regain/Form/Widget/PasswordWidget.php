<?php

namespace regain\Form\Widget;

use regain\Form\Widget\WidgetAbstract;

class PasswordWidget extends WidgetAbstract {
    protected $type = 'password';
    
    public function output($field) {
        return $this->parse($this->type, $field->get_name());
    }
}