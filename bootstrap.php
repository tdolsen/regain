<?php

// Let's make sure files are found
function __autoload($class) {
    require_once str_replace(array('\\'), array('/'), $class) . '.php';
}

use regain\HTTP\Request
  , regain\Middleware\Middleware
  , regain\Settings\Settings
  , regain\URL\Router
  ;

// Fetch the project settings file
assert('file_exists("settings.php") /* The settings.php file does not exist. Each project need to have at least one when using the bootstrapper. */');
require 'settings.php';

// Overwrite default settings with project settings
assert('isset($settings) /* The settings.php file is malformatted. It has to contain an associative array named $settings. */');
Settings::update($settings);

// Setting up required variables
$request = new Request();
$middleware = new Middleware($settings->middleware);
$settings = new Settings();
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

// Process response middleware
$middleware->process_response($request, $response);

// Get that response out!!!
echo $response;
