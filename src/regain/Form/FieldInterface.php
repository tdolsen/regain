<?php

namespace regain\Form;

interface FieldInterface {
    public function is_bound();
    public function is_valid();
    
    public function set_inital($initial);
    public function set_value($value);
    
    public function __toString();
}