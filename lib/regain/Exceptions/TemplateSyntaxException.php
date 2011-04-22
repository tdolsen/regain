<?php

namespace regain\Exceptions;

class TemplateSyntaxException extends Exception {
    
    protected $lineno;
    protected $filename;
    protected $message;
    
    public function __construct($message, $line, $file) {
        $this->message = $message;
        $this->line = $line;
        $this->file = $file;
        
        parent::__construct($message, $line);
    }
}
