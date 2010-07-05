<?php

// You can skip this, but you would then have to use the full namespace path
use regain\URL\Patterns;

$patterns = new Patterns(
  array(
    '^$' => 'views\dashboard'
  )
);
