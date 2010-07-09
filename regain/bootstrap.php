<?php

namespace regain;

require 'regain/functions.php';
require 'regain/shortcuts.php';

use regain\HTTP\Request
  , regain\HTTP\Response
  , regain\HTTP\ResponseNotFound
  , regain\Middleware\Middleware
  , regain\Settings\Settings
  , regain\URL\Router
  , regain\Exceptions\Exception
  , regain\Exceptions\IncludeException
  , regain\assert
  , regain\is_includable
  , regain\autoload
  , regain\_include
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

	// TODO: Process urls middleware; do we have to?
	//$middleware->process_urls($request, $patterns);

	// Set up the router and get view
	//$router = new Router($patterns);
	$view = $patterns->get_view($request->path);

	if($view === null) {
	    $response = new ResponseNotFound();
	    goto response;
	}

	$view = explode('\\', $view);
	$v = array(
	    'function' => array_pop($view),
	    'file' => array_pop($view),
	    'path' => implode('/', $view)
	);

	if(strlen($v['path']) > 0) {
	    $v['path'].= '/';
	}

	_include($v['path'] . $v['file'] . '.php');

	// TODO: Process view middleware
	//$middleware->process_view($request, $view);

	// Run the view
//	$response = @call_user_func($view, $request);

	if(!function_exists($v['function'])) {
	    throw new Exception('Function "' . $v['function'] . '" does not exist.');
	}

	$response = $v['function']($request);

	// And throw an exception if response is of wrong type
	if(!$response instanceof Response) {
	    throw new \UnexpectedValueException('The return value of view functions must be an instance of HTTP\Response');
	}

	// Process response middleware
	$middleware->process_response($request, $response);

        // goto label for outputting response
        response:

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
    include 'regain/templates/debug/include_exception.php';
    exit;
} catch(\Exception $e) {
    echo "<h1>Reached bottom catch</h1>";
    print_r($e);
}
