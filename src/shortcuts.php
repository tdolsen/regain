<?php

use regain\HTTP\Response
  , regain\Template
  ;

function render_to_response($template, $data=null) {
    $t = new Template($data);
    return new Response($t->render($template));
}
