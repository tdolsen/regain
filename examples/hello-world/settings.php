<?php

/*
 The settings file should only contain the one variable $settings.
 Adding other contents to this file might make the framework break.

 The $settings variable is an associative array, where the key is the same used
 for looking up settings with the regain\Settings class.

 It can only be one set of settings per project.
*/

$settings = array(
  /*
   It set to 'true', all errors will be displayed and with detailed information.

   When 'false', errors will be displayed using the projects error pages,
   or standard error messages. It won't contain any information about the error(except type).
  */
  'debug' => true,

  /*
   Each middleware class should be represented as a string, using a full
   namespace path. Middleware classes are executed in order, so be aware
   of dependencies.
  */
  'middleware' => array(
#    'regain\Session\Middleware\Session',
#    'regain\Authentication\Middleware\Authentication',
#    'regain\Authentication\Middleware\RequireAuthenticaton'
  )
);
