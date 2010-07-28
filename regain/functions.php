<?php

namespace regain;

use regain\Exceptions\ErrorException;

// We need this to test for file inclusion. Required to catch errors pretty.
function is_includable($file) {
    $ip = explode(PATH_SEPARATOR, get_include_path());
    $file = ltrim($file, '/');

    foreach($ip as $path) {
        $f = rtrim($path, '/') . '/' . $file;
        if(file_exists($f)) {
            return true;
        }
    }

    return false;
}

// Throw php errors as ErrorException
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    if(strtolower(substr($errstr, 0, 7)) == 'require') {
	die("require error");
    }
    throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
}

// Let's make sure files are found
function autoload($class) {
    $file = str_replace(array('\\', '_'), array('/', '/'), $class) . '.php';

    if(!is_includable($file)) {
	throw new Exceptions\IncludeException($file, 'The file "' . $file . '" is not in include_path, and cannot be included.');
    }

    try {
	require_once $file;
    } catch (ErrorException $e) {
	throw new Exceptions\IncludeException($file, 'The file "' . $file . '" is malformatted.');
    }
}

// A integrated way to assert certain values. Will throw an AssertException if
// first parameter is false, with the string in the second parameter as text.
// First parameter has to be bool.
function assert($true, $text) {
    if(!is_bool($true)) {
        throw new Exceptions\TypeException('First parameter of regain\assert must be boolean.');
    }
    if(!$true) {
        throw new Exceptions\AssertException($text);
    }
}

// Wrappers includes to throw exceptions on error
function __process_include($type, $file, &$var=null) {
    if(!is_includable($file)) {
        throw new Exceptions\IncludeException($file);
    }
    switch($type) {
        case 'include': include $file; break;
        case 'include_once': include_once $file; break;
        case 'require': require $file; break;
        case 'require_once': require_once $file; break;
    }
    if(is_array($var) and count($var) > 0) {
        $t = $var;
        $var = array();
        foreach($t as $k) {
            $var[$k] = $$k;
        }
    }
}

function _include($file, &$var=null) { __process_include('include', $file, $var); }
function _include_once($file, &$var=null) { __process_include('include_once', $file, $var); }
function _require($file, &$var=null) { __process_include('require', $file, $var); }
function _require_once($file, &$var=null) { __process_include('require_once', $file, $var); }

// Lazy loader for including urls
class LazyUrlsLoader {
    protected $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function __load() {
        $up = array('patterns');
        _require($this->file, $up);
        return $up['patterns'];
    }
}

// Offers a way to add hierarcial urls.php definitions
function include_urls($file) {
    return new LazyUrlsLoader($file);
}

// sprintf with named variables
function sprintfn ($format, array $args = array()) {
    // map of argument names to their corresponding sprintf numeric argument value
    $arg_nums = array_slice(array_flip(array_keys(array(0 => 0) + $args)), 1);

    // find the next named argument. each search starts at the end of the previous replacement.
    for ($pos = 0; preg_match('/(?<=%)([a-zA-Z_]\w*)(?=\$)/', $format, $match, PREG_OFFSET_CAPTURE, $pos);) {
        $arg_pos = $match[0][1];
        $arg_len = strlen($match[0][0]);
        $arg_key = $match[1][0];

        // programmer did not supply a value for the named argument found in the format string
        if (! array_key_exists($arg_key, $arg_nums)) {
            user_error("sprintfn(): Missing argument '${arg_key}'", E_USER_WARNING);
            return false;
        }

        // replace the named argument with the corresponding numeric one
        $format = substr_replace($format, $replace = $arg_nums[$arg_key], $arg_pos, $arg_len);
        $pos = $arg_pos + strlen($replace); // skip to end of replacement for next iteration
    }

    return vsprintf($format, array_values($args));
}