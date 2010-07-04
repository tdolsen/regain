<?php

$settings = array(
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
