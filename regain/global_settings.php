<?php

$settings = array(
    /* Custom autoload callback to overwrite regain's default behaviour
    'autoload' => 'regain/autoload',
    // Note: Must be defined in project settings, only here for reference*/

    // Debug always off as standard
    'debug' => false,

    // The name of the urls file, excluding .php
    'urls_file' => 'urls',

    // Standard middleware classes in a simple project
    'middleware' => array(
        'regain\Cookies\Middleware\CookiesMiddleware',
        'regain\Session\Middleware\SessionMiddleware'
    )
);
