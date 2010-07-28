<?php

namespace regain;

require_once 'regain/functions.php';
require_once 'regain/shortcuts.php';
require_once 'regain/Exceptions/Exception.php';
require_once 'regain/Exceptions/AssertException.php';

use regain\HTTP\Request
  , regain\HTTP\Response
  , regain\HTTP\ResponseNotFound
  , regain\Middleware
  , regain\Settings
  , regain\URL\Patterns
  , regain\Exceptions\Exception
  , regain\Exceptions\IncludeException
  , regain\Exceptions\AssertException
  ;

try {
    // Fetch the project settings file
    assert(file_exists('settings.php'), 'The settings.php file does not exist. Each project need to have at least one when using the bootstrapper.');
    require 'settings.php';
    
    // Check if there is set a custom autoloader set, if not use regains
    $autoload = isset($settings['autoload']) ? $settings['autoload'] : 'regain\autoload';
    
    // Autoload files from here
        spl_autoload_register($autoload);
    
    // Overwrite default settings with project settings
    assert(isset($settings), 'The settings.php file is malformatted. It has to contain an associative array named $settings.');
    $settings = new Settings($settings);
    
    // Setting up required variables
    $request = new Request();
    $middleware = new Middleware($settings->middleware);
    
    // Process request middleware
    $middleware->process_request($request);
    
    // Get the url patterns
    assert(file_exists($settings->urls_file . '.php'), 'The urls file "' . $settings->urls_file . '.php" does not exist. Make sure the file exist and that it matches your setting in settings.php.');
    require $settings->urls_file . '.php';
    
    // Set up the router and get view
    assert((isset($patterns) and $patterns instanceof Patterns), 'The ' . $settings->urls_file . '.php is malformatted. It has to conatin an instance of regain\URL\Patterns named $patters.');
    $view = $patterns->get_view($request->path);
    
    if($view === null) {
        $response = new ResponseNotFound();
        goto process_response;
    }
    
    $view = preg_split('#[/\\\]#', $view);
    
    $v = array(
        'function' => array_pop($view),
        'file' => array_pop($view),
        'path' => implode('/', $view)
    );
    
    if(strlen($v['path']) > 0) {
        $v['path'].= '/';
    }
    
    $file = $v['path'] . $v['file'] . '.php';
    
    _include($file);
    
    // TODO: Process view middleware
    //$middleware->process_view($request, $view);
    
    // Run the view
    //	$response = @call_user_func($view, $request);
    
    if(!function_exists($v['function'])) {
        // TODO: Make this a special exception for easier debugging
        throw new Exception('Function "' . $v['function'] . '" does not exist.');
    }
    
    $response = $v['function']($request);
    
    // And throw an exception if response is of wrong type
    if(!$response instanceof Response) {
        throw new \UnexpectedValueException('The return value of view functions must be an instance of HTTP\Response');
    }
    
        // goto label for process response middleware
        process_response:
    
    // Process response middleware
    $middleware->process_response($request, $response);
    
    // Test for debug-output
    if($settings->debug) {
        if($response instanceof ResponseNotFound) {
            include 'regain/templates/debug/404.php';
            exit;
        }
    }
    
    // Get that response out!!!
    echo $response;
    exit;
} catch(IncludeException $e) {
    include 'regain/debug/include_exception.php';
    exit;
} catch(AssertException $e) {
    include 'regain/debug/assert_exception.php';
    exit;
} catch(\Exception $e) {
    include 'regain/debug/exception.php';
}