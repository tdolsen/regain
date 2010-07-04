<?php

namespace regain;

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
	#die("require error");
    }
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}



// Let's make sure files are found
function autoload($class) {
    $file = str_replace(array('\\'), array('/'), $class) . '.php';

    if(!is_includable($file)) {
	throw new IncludeException('The file "' . $file . '" is not in include_path, and cannot be included.');
    }

    try {
	require_once $file;
    } catch (ErrorException $e) {
	throw new IncludeException('The file "' . $file . '" is malformatted.');
    }
}



// A integrated way to assert certain values. Will throw an AssertException if
// first parameter is false, with the string in the second parameter as text.
// First parameter has to be bool.
function assert($true, $text) {
    if(!is_bool($true)) {
        throw new TypeException('First parameter of regain\assert must be boolean.');
    }
    if(!$true) {
        throw new AssertException($text);
    }
}
