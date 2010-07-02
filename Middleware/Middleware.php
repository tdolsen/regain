<?php

namespace regain\Middleware;
use regain\HTTP\Response;

class Middleware {
    private $middleware = array();

    public function __construct(array $middleware) {
        foreach($middleware as $mw) {
            $this->middleware[] = new $mw();
        }
    }

    private function process($action, $request, $response = null) {
        foreach($this->middleware as $mw) {
            if(function_exists(array($mw, $action))) {
                switch($action) {
                    case 'request':
                        $res = call_user_func(array($mw, 'process_request'), $request);
                        break;
                    case 'response':
                        $res = call_user_func(array($mw, 'process_response'), $request, $response);
                        break;
                }

                if($res != null) {
                    if(!$res instanceof Response) {
                        throw new Exception('The middleware class "' . get_class($mw) . '" returned an unknown result for "process_' . $action . '". Must return an instance of HTTP\Response or null.');
                    }

                    return $res;
                }
            }
        }
    }

    public function process_request($request) {

    }

    public function process_response($request, $response) {

    }
}
