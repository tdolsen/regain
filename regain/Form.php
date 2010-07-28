<?php

namespace regain;

use regain\Form\FieldInterface,
    regain\Utils\sprintfn
  ;

abstract class Form {
    protected $_fields = array();

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
    
    protected function output_html($wrapper, $row_wrapper, $normal_row, $error_wrapper, $error_row, $help_text) {
        $out = "";
        
        foreach($this->fields as $field) {
            $widget = $field->get_widget();
            
            $row = sprintfn($normal_row, array(
                'html_class' => $field->get_class(),
                'field' => $widget->get_field(),
                'help_text' => sprintfn($help_text, array('help_text' => $field->help_text))
            ));
            
            if(!$field->is_valid()) {
                $errors = "";
                
                foreach($field->errors as $error) {
                    $errors.= sprintfn($error_row, array('error' => $error, 'error_class' => ' class="error"'));
                }
                
                $errors = sprintfn($error_wrapper, array('errors' => $errors, 'errors_class' => ' class="errors"'));
            } else {
                $errors = '';
            }
            
            $out.= sprintfn($row_wrapper, array('errors' => $errors, 'row' => $row));
        }
        
        return sprintfn($wrapper, array('fields' => $out));
    }
    
    public function __toString() {
        return $this->output_html(
            
        );
    }
    
    public function as_p() {
        return $this->output_html(
            '%fields$s',
            '%errors$s\n%row$s',
            '<p%html_class$s>%field$s %help_text$s</p>',
            '<ul%errors_class$s>%errors$s</ul>',
            '<li%error_class$s>%error$s</li>',
            '<span>%help_text$s</span>'
        );
    }
    
    public function as_ul() {
        
    }
}