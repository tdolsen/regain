<?php

namespace regain\Exceptions;
 
class IncludeException extends \Exception {
    protected $include_file;

    public function __construct($include_file, $text=null) {
        $this->include_file = $include_file;
        if(isset($test)) {
            parent::__construct($text);
        }
    }

    public function getIncludeFile() {
        return $this->include_file;
    }
}
