<?php

namespace regain\Middleware;
use regain\HTTP\Response
  , regain\Settings\Settings
  ;

class Middleware {
    private $middleware = array();

    public function __construct(array $middleware) {
        $settings = new Settings();
        foreach($middleware as $mw) {
            $this->middleware[] = new $mw($settings);
        }
    }

    private function process($action, &$request, &$response = null) {
        $action = 'process_' . $action;
        foreach($this->middleware as $mw) {
            if(function_exists(array($mw, $action))) {
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
