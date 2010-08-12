<?php

$settings = array(
    // This option should only be used during development or in special cases.
    // It prefixes any absolute path in the system with it.
    // Usefull when mod_rewirte can't be used.
    'absolute_path_prefix' => '',
    
    // Appends a slash to the end of the path name and redirects to the page,
    // if no matches where found without
    'append_slash' => true,
    
    /* Custom autoload callback to overwrite regain's default behaviour
    'autoload' => 'regain/autoload',
    // Note: Must be defined in project settings, only here for reference*/
    
    // The charset your project should be outputted with
    'charset' => 'utf-8',
    
    // Debug always off as standard
    'debug' => false,

    // Standard middleware classes in a simple project
    'middleware' => array(
        'regain\Middleware\Common'
    ),
    
    // The template engine is subject to personal preference, but Twig comes as standard
    // Be aware that Twig does not come packed with regain, so it needs to be installed seperatly
    'template_engine' => 'regain\Template\Adapters\Twig\Engine',

    // Deault template path don't make much sence, therefor its only two relativt paths
    // This setting is an atempt to normalize paths, but could break some engines, so be aware
    'template_paths' => array(
        'templates',   // This equals to ./templates
        '../templates' // This equals to ../templates
    ),

    // The name of the urls file, excluding .php
    'urls_file' => 'urls'
);