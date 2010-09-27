<?php

namespace regain\Form;

interface FieldInterface {
    public function is_bound();
    public function is_valid();
    public function is_required();
    public function is_empty();
    public function is_set();
    
    public function cleaned_value();
    
    public function set_name($name);
    public function get_initial();
    public function set_initial($initial);
    public function get_value();
    public function set_value($value);
    
    public function get_help_text();
    
    public function __toString();
}