<?php

use regain\HTTP\Response
  , regain\HTTP\ResponseNotFound
  , regain\HTTP\ResponseRedirect
  , regain\Template
  ;

/**
 * Returns a Response object with given template parsed.
 *
 * @param string $template The template name to load
 * @param array $data      The data array
 *
 * @return Response The response object ready for outputting
 */
function render_to_response($template, $data = null) {
    $t = new Template($template);
    return new Response($t->render($data));
}

/**
 * Returns a ResponseNotFound with a parsed template.
 * Automatically loads the template 'errors/404.html', but can be overwritten.
 *
 * @param string $template The template name to load
 * @param array $data      Variables made available to the template
 * @param array $headers   Additional headers
 *
 * @return ResponseNotFound The response object returned with a status of 404
 */
function render_not_found($template = 'errors/404.html', $data = null, array $headers = null) {
    $t = new Template($template);
    return new ResponseNotFound($t->render($data), $headers);
}

/**
 * Returns a ResponseRedirect object set up to redirect the client to given destination.
 *
 * @param string $to     The destination to redirect to
 * @param array $headers Additional headers
 *
 * @return ResponseRedirect The response object with redirect headers set
 */
function redirect($to, array $headers = null) {
    return new ResponseRedirect($to, $headers);
}