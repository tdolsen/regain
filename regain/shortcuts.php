<?php

use regain\HTTP\Response
  , regain\Template
  ;

function render_to_response($template, $data=null) {
    $t = new Template($template);
    return new Response($t->render($data));
}