<?php

namespace regain\Form\Widget;

use regain\Form\Widget\WidgetInterface;

abstract class WidgetAbstract implements WidgetInterface {
    protected $type = 'text';
    
    public function output($field) {
        $class = $field->is_valid() ? null : 'error';
        return $this->parse($this->type, $field->get_name(), $field->get_value(), $class);
    }
    
    protected function parse($type, $name, $value = '', $class = null) {
        $o = '<input type="' . $type . '" '
           . 'name="' . $name . '" '
           . 'id="inp_' . $name . '" '
           . (isset($class) ? 'class="' . $class . '" ' : '')
           . (!empty($value) ? ' value="' . $value . '" ' : null)
           . '/>';
        return $o;
    }
}