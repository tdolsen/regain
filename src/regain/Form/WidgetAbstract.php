<?php

namespace regain\Form;

use regain\Form\WidgetInterface;

abstract class WidgetAbstract implements WidgetInterface {
    protected $type = 'text';
    
    public function output($field) {
        $o = '<input type="text" '
           . 'name="inp_' . $field->get_name() . '" '
           . !empty($value) ? ' value="' . $field->get_value() . '" ' : null
           . '/>';
    }
}