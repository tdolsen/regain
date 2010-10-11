<?php

namespace regain\Form\Widget;

use regain\Form\Widget\WidgetAbstract;

class TextareaWidget extends WidgetAbstract {
    public function output($field) {
        $o = '<textarea '
           . 'name="' . $field->get_name() . '" '
           . 'id="inp_' . $field->get_name() . '"'
           . '>' . $field->get_value() . '</textarea>';
        return $o;
    }
}