<?php

namespace regain;

require 'regain/functions.php';

use regain\HTTP\Request
  , regain\HTTP\Response
  , regain\HTTP\ResponseNotFound
  , regain\Middleware\Middleware
  , regain\Settings\Settings
  , regain\URL\Router
  , regain\Exception
  , regain\IncludeException
  , regain\assert
  , regain\is_includable
  , regain\autoload
  ;

try {
	// Autoload files from here
        spl_autoload_register('regain\autoload');

	// Fetch the project settings file
	assert(file_exists('settings.php'), 'The settings.php file does not exist. Each project need to have at least one when using the bootstrapper.');
	require 'settings.php';

	// Overwrite default settings with project settings
	assert(isset($settings) ,'The settings.php file is malformatted. It has to contain an associative array named $settings.');
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
            throw new ResponseNotFound();
        }

	// TODO: Process view middleware
	//$middleware->process_view($request, $view);

	// Run the view
//	$response = @call_user_func($view, $request);
	$response = $view($request);

	// And throw an exception if response is of wrong type
	if(!$response instanceof Response) {
	throw new UnexpectedValueException('The return value of view functions must be an instance of HTTP\Response');
	}

	// Process response middleware
	$middleware->process_response($request, $response);

	// Get that response out!!!
	echo $response;
} catch(IncludeException $e) {
    include 'regain/templates/errors/IncludeException.php';
    exit;
} catch(Exception $e) {
    echo "<h1>Reached bottom catch</h1>";
    print_r($e);
}
