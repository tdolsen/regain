<?php

use regain\HTTP\Response
  , regain\Template
  ;

/**
 * A shortcut function for creating a Response object with a status of 404.
 * Automatically tries to load the template 'errors/404.html', but can be overwritten.
 *
 * @param string $template The template name to load
 *
 * @return Response The regain\HTTP\Response object returned with a status of 404
 */
function render_not_found($template = 'errors/404.html') {
    $t = new Template($template);
    return new Response($t->render(), 404);
}

/**
 * A shortcut function for converting a template name and data array to a Response
 * object.
 *
 * @param string $template The template name to load
 * @param array $data      The data array
 *
 * @return Response The response object ready for outputting
 */
function render_to_response($template, $data=null) {
    $t = new Template($template);
    return new Response($t->render($data));
}