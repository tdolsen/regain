<?php

use regain\HTTP\Response
  , regain\Template
  ;

function render_to_response($template, $data=null) {
    $t = new Template($template);
    return new Response($t->render($data));
}

function render_not_found($template = 'errors/404.html') {
    $t = new Template($template);
    return new Response($t->render(), 404);
}