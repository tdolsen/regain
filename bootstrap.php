<?php

// Let's make sure files are found
function __autoload($class) {
    require_once str_replace(array('\\'), array('/'), $class) . '.php';
}

use regain\HTTP\Request
  , regain\Middleware\Middleware
  , regain\Settings\Settings
  ;

// Fetch the project settings file
assert('file_exists("settings.php") /* The settings.php file does not exists. Each project need to have at least one when using the bootstrapper. */');
require 'settings.php';

// Overwrite default settings with project settings
assert('isset($settings) /* The settings.php file is malformatted. It has to contain an associative array named $settings. */');
Settings::update($settings);

// Setting up required variables
$request = new Request();
$middleware = new Middleware($settings->middleware);

// Process request middleware
$middleware->process_request($request);
