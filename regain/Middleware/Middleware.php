<?php

namespace regain\Middleware;
use regain\HTTP\Response
  , regain\Settings\Settings
  , regain\TypeException
  ;

class Middleware {
    private $middleware = array();

    public function __construct(array $middleware) {
        foreach($middleware as $mw) {
            $mw = new $mw();
            if(!$mw instanceof Skeleton) {
                 throw new TypeException('All middleware classes need to be an instance of "regain\Middleware\Skeleton".');
            }
            $this->middleware[] = $mw;
        }
    }

    private function process($action, &$request, &$response = null) {
        $action = 'process_' . $action;
        foreach($this->middleware as $mw) {
            if(method_exists($mw, $action))  {
                $res = $mw->$action($request, $response);
                if($res != null) {
                    if(!$res instanceof Response) {
                        throw new Exception('The middleware class "' . get_class($mw) . '" returned an unknown result for "process_' . $action . '". Must return an instance of HTTP\Response or null.');
                    }

                    throw new $res;
                }
            }
        }
    }

    public function process_request(&$request) {
        $this->process('request', $request);
    }

    public function process_response($request, &$response) {
        $this->process('response', $request, $response);
    }
}
