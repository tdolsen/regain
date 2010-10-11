<?php

namespace regain\Form;

use regain\Form\WidgetAbstract;

class TextareaWidget extends WidgetAbstract {
    public function output($field) {
        $o = '<textarea '
           . 'name="' . $field->get_name() . '" '
           . 'id="inp_' . $field->get_name() . '"'
           . '>' . $field->get_value() . '</textarea>';
        return $o;
    }
}