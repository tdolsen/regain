<?php

namespace regain;

use regain\Form\Field\FieldInterface;

abstract class Form {
    protected $bound;
    protected $valid;
    
    protected $_fields = array();

    public function __construct($data = null, $initial = array()) {
        // Figureing out if the form is bound
        if(!is_null($data) and is_array($data)) {
            $this->bound = true;
        } else {
            $data = array();
            $this->bound = false;
        }
        
        // Setting up the fields
        $this->setup();
        
        foreach(get_object_vars($this) as $key => $field) {
            if($field instanceof FieldInterface) {
                $field->set_name($key);
                if(isset($initial[$key])) $field->set_initial($initial[$key]);
                if(isset($data[$key])) $field->set_value($data[$key]);
                $this->_fields[$key] = $field;
            }
        }
    }
    
    abstract protected function setup();
    
    public function __get($name) {
        return $this->_fields[$name]->cleanded_value();
    }
    
    public function __isset($name) {
        return $this->_fields[$name]->is_set();
    }
    
    public function is_bound() {
        return $this->bound;
    }
    
    public function is_valid() {
        if(!isset($this->valid)) {
            $this->valid = true;
            
            foreach($this->_fields as $field) {
                if(!$field->is_valid()) {
                    $this->valid = false;
                    break;
                }
            }
        }
        
        return $this->valid;
    }
    
    protected function output_html($wrapper, $row_wrapper, $normal_row, $error_wrapper, $error_row, $help_text) {
        $out = "";
        
        foreach($this->_fields as $field) {
            $help_text = $field->get_help_text();
            
            $row = sprintfn($normal_row, array(
                'html_class' => '',
                'field' => (string) $field,
                'help_text' => !empty($help_text) ? ' ' . sprintfn($help_text, array('help_text' => $help_text)) : ''
            ));
            
            if($this->is_bound() and !$field->is_valid()) {
                $errors = '';
                
                #foreach($field->errors as $error) {
                #    $errors.= sprintfn($error_row, array('error' => $error, 'error_class' => ' class="error"'));
                #}
                
                #$errors = sprintfn($error_wrapper, array('errors' => $errors, 'errors_class' => ' class="errors"'));
            } else {
                $errors = '';
            }
            
            $out.= sprintfn($row_wrapper, array('errors' => $errors, 'row' => $row));
        }
        
        return sprintfn($wrapper, array('fields' => $out));
    }
    
    public function __toString() {
        return $this->as_p();
    }
    
    public function as_p() {
        return $this->output_html(
            '%fields$s',
            '%errors$s' . "\n" . '%row$s',
            '<p%html_class$s>%field$s%help_text$s</p>',
            '<ul%errors_class$s>%errors$s</ul>',
            '<li%error_class$s>%error$s</li>',
            '<span>%help_text$s</span>'
        );
    }
}