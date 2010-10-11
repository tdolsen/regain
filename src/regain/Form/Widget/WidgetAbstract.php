<?php

namespace regain\Form\Widget;

use regain\Form\Widget\WidgetInterface;

abstract class WidgetAbstract implements WidgetInterface {
    protected $type = 'text';
    
    public function output($field) {
        return $this->parse($this->type, $field->get_name(), $field->get_value());
    }
    
    protected function parse($type, $name, $value = '') {
        $o = '<input type="' . $type . '" '
           . 'name="' . $name . '" '
           . 'id="inp_' . $name . '" '
           . (!empty($value) ? ' value="' . $value . '" ' : null)
           . '/>';
        return $o;
    }
}