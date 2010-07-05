<?php

use regain\HTTP\Response;

/*
 The first parameter will always be the HTTP\Request object.

 To reflect changes you make on that object later in your application,
 you should pass it by reference. But in most situations, a middleware
 class would be better.
*/
function dashboard($request) {
    return new Response('Hello world!');
}
