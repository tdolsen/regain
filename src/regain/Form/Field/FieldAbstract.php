<?php

namespace regain\Form\Field;

use regain\Form\Widget\TextWidget;

abstract class FieldAbstract implements FieldInterface {
    protected $name;
    
    protected $bound = false;
    
    protected $empty = false;
    protected $required = true;
    
    protected $value;
    protected $initial = '';
    protected $help_text = '';
    
    protected $widget;
    
    public function __construct($params = array()) {
        foreach($params as $key => $value) {
            if($key == 'empty') {
                $this->empty = $value;
            } elseif($key == 'required') {
                $this->required = $value;
            } elseif($key == 'initial') {
                $this->initial = $value;
            } elseif($key == 'widget') {
                $this->widget = $value;
            } elseif($key == 'help_text') {
                $this->help_text = $value;
            }
        }
        
        if(!isset($this->widget)) {
            $this->widget = new TextWidget();
        }
    }
    
    // This is intended to create the field specific validations
    public function validate() {
        return true;
    }
    
    public function is_bound() {
        return $this->bound;
    }
    
    public function is_empty() {
        return isset($this->value) ? empty($this->value) : false;
    }
    
    public function is_required() {
        return $this->required;
    }
    
    public function is_set() {
        return isset($this->value) ? empty($this->value) ? false : true : false;
    }
    
    public function is_valid() {
        if($this->required and !$this->bound) return false;
        if(!$this->empty and empty($this->value)) return false;
        return $this->validate();
    }
    
    public function get_value() {
        return htmlspecialchars($this->value);
    }
    
    public function cleaned_value() {
        return $this->get_value();
    }
    
    public function set_value($value) {
        $this->value = $value;
        $this->bound = true;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function set_name($name) {
        $this->name = $name;
    }
    
    public function get_initial() {
        return $this->initial;
    }
    
    public function set_initial($initial) {
        $this->initial = $initial;
    }
    
    public function get_help_text() {
        return (string) $this->help_text;
    }
    
    public function __toString() {
        return $this->widget->output($this);
    }
}