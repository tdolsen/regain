<?php

$settings = array(
    /* Custom autoload callback to overwrite regain's default behaviour
    'autoload' => 'regain/autoload',
    // Note: Must be defined in project settings, only here for reference*/

    // Deault template path don't make much sence, therefor its only two relativt paths
    'template_paths' => array(
        'templates',   // This equals to ./templates
        '../templates' // This equals to ../templates
, '/templates', '/var/www/templates', 'C:/templates'
    ),

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
