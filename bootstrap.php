<?php

use regain\HTTP\Request
  , regain\HTTP\Response
  , regain\Middleware\Middleware
  , regain\Settings\Settings
  , regain\URL\Router
  , regain\Exception
  , regain\IncludeException
  ;



try {
	/*
	 TODO: All these system function should be moved to a seperate file and only activated here.
	*/

	if(!function_exists('is_includable')) {
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
	}

	// Throw php errors as ErrorException
	function exception_error_handler($errno, $errstr, $errfile, $errline ) {
	    if(strtolower(substr($errstr, 0, 7)) == 'require') {
		#die("require error");
	    }
	    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	}
	set_error_handler("exception_error_handler");

	// Let's make sure files are found
	function __autoload($class) {
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

/* END OF SYSTEM FUNCTIONS. ALSO: TODO: Move the to another file, only active here. Yeah. */

	// Fetch the project settings file
	assert('file_exists("settings.php") /* The settings.php file does not exist. Each project need to have at least one when using the bootstrapper. */');
	require 'settings.php';

	// Overwrite default settings with project settings
	assert('isset($settings) /* The settings.php file is malformatted. It has to contain an associative array named $settings. */');
	$settings = new Settings($settings);

	// Setting up required variables
	$request = new Request();
	$middleware = new Middleware($settings->middleware);

	$router = new Router();

	// Process request middleware
	$middleware->process_request($request);

	// Get the url patterns
	assert('file_exists("' . $settings->urls_file . '.php") /* The urls file "' . $settings->urls_file . '.php" does not exist. Make sure the file exist and that it matches your setting in settings.php. */');
	require $settings->urls_file . '.php';

	// TODO: Process urls middleware
	//$middleware->process_urls($request, $patterns);

	// Set up the router and get view
	$router = new Router($patterns);
	$view = $router->get_view($request->path);

	// TODO: Process view middleware
	//$middleware->process_view($request, $view);

	// Run the view
	$response = call_user_func($view, $request);

	// And throw an exception if response is of wrong type
	if(!$response instanceof Response) {
	throw new UnexpectedValueException('The return value of view functions must be an instance of HTTP\Response');
	}

	// Process response middleware
	$middleware->process_response($request, $response);

	// Get that response out!!!
	echo $response;
} catch(Exception $e) {
    echo "<h1>Reached bottom catch</h1>";
    print_r($e);
}
