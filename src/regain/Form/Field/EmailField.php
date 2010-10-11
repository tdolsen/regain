<?php

namespace regain\Form\Field;

use regain\Form\Field\FieldAbstract;

class EmailField extends FieldAbstract {
    public function validate() {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL) ? true : false;
    }
}