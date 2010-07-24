<?php

namespace regain;

use regain\Form\FieldInterface
  ;

abstract class Form {
    protected $_fields = array();
    protected $_data;

    public function __construct($data = null, array $initial = array()) {
        // Figureing out if the form is bound
        if(!is_null($data) and is_array($data)) {
            $this->bound = true;
        } else {
            $data = array();
            $this->bound = false;
        }
        
        // Setting up the fields
        foreach(get_object_vars($this) as $key => $field) {
            if($field instanceof FieldInterface) {
                if(isset($initial[$key])) $field->set_inital($initial[$key]);
                if(isset($data[$key])) $field->set_value($data[$key]);
                $this->_fields[] = array($key, $field);
            }
        }
    }
    
    protected function __set($name, $value) {
        $this->_data[$name] = $value;
    }
    
    public function __get($name) {
        if($key == 'errors') {
            
        } elseif($key == 'cleaned_data') {
            
        } elseif(substr($key, 0, 3) == 'as_') {
            
        } else {
            return $this->_data[$name];
        }
    }
    
    public function __isset($name) {
        return isset($this->_data[$name]);
    }
    
    public function __toString() {
        $out = "";
        foreach($this->fields as $field) {
            $out.= (string) $field[1];
        }
        return $out;
    }
    
    public function is_bound() {
        return $this->bound;
    }
    
    public function is_valid() {
        if(!isset($this->valid)) {
            $this->valid = true;
            
            foreach($this->_fields as $field) {
                if(!$field[1]->is_valid()) {
                    $this->valid = false;
                    break;
                }
            }
        }
        
        return $this->valid;
    }
}