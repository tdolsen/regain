<?php

namespace regain\Form;

use regain\Form\WidgetInterface;

abstract class WidgetAbstract implements WidgetInterface {
    protected $type = 'text';
    
    public function output($field) {
        return $this->parse($this->type, $field->get_name(), $field->get_value());
    }
    
    protected function parse($type, $name, $value = '') {
        $o = '<input type="' . $type . '" '
           . 'name="' . $name . '" '
           . (!empty($value) ? ' value="' . $value . '" ' : null)
           . '/>';
        return $o;
    }
}