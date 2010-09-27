<?php

namespace regain\Form;

use regain\Form\WidgetAbstract;

class PasswordWidget extends WidgetAbstract {
    protected $type = 'password';
    
    public function output($field) {
        return $this->parse($this->type, $field->get_name());
    }
}