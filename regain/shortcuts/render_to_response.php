<?php

namespace regain\shortcuts;

use regain\HTTP\Response
  , regain\Template
  ;

class render_to_response {
    public function __construct($template, $data=null) {
        $t = new Template($data);
        return new Response($t->render($template));
    }
}
