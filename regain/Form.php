<?php

namespace regain;

use regain\Form\FieldInterface
  ;

abstract class Form {
    protected $fields = array();
    protected $data;
    protected $valid;

    public function __construct($data = null, $initial = array()) {
        // Setting up the fields
        foreach(get_object_vars($this) as $key => $field) {
            if($field instanceof FieldInterface) {
                if(isset($initial[$key])) $field->inital = $initial[$key];
                $this->fields[] = array($key, $field);
            }
        }

        // Checking for data, and adding to appropriate fields
        if(!is_null($data) and is_array($data)) {
            foreach($data as $key => $value) {
                if(isset($this->fields[$key])) {
                    $this->fields[$key]->set_value($value);
                }
            }
        }
    }

    public function is_valid() {
        foreach($this->fields as $field) {
            if(!$field->is_valid) {
                return false;
            }
        }
        return true;
    }

    public function __get($key) {
        if($key == 'errors') {

        } elseif($key == 'cleaned_data') {

        } elseif(substr($key, 0, 3) == 'as_') {

        }
    }
}
