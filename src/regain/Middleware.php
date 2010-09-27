<?php

namespace regain;

use regain\HTTP\Response
  , reagin\HTTP\Request
  , regain\Settings
  , regain\Exceptions\TypeException
  , regain\Middleware\MiddlewareInterface
  ;

/**
 * The class keeping track off and handeling middleware classes.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class Middleware {
    /**
     * The variable keeping all middleware classes.
     *
     * @var $middleware array
     */
    protected $middleware = array();
    
    /**
     * The constructor, responsible for setting up and validating the middleware
     * classes.
     *
     * @param array $middleware The array of middleware classes
     *
     * @return null
     */
    public function __construct(array $middleware) {
        foreach($middleware as $mw) {
            $this->middleware[] = new $mw();
        }
    }
    
    /**
     * A method for processing the defined action in all middleware classes.
     * Both the request and response object it passed as a reference to this method.
     *
     * @param string $action      The action to run in the middleware class, without
     *                            the 'process_' prefix.
     * @param Request &$request   The regain\HTTP\Request object for modification
     * @param Response &$response The regain\HTTP\Response object for modification
     *
     * @return Response|null Returns the value returned from the middleware if it
     *                       is an instance of Response(and in that case goes staight
     *                       to output). Returns nothing else.
     */
    
    /**
     * A simple wrapper method around {@link process()} for processing the request.
     *
     * @param Request $request The regain\HTTP\Request object
     *
     * @return Response|null {@see process()}
     */
    public function process_request($request) {
        foreach($this->middleware as $mw) {
            if(method_exists($mw, 'process_request')) {
                $res = $mw->process_request($request);
                
                if(!$res instanceof Request) {
                    if($res instanceof Response) {
                        return $res;
                    } else {
                        throw new TypeException('The process_request method expects a Request or Response object in return. "' . get_class($mw) . '" return an object of type "' . gettype($res) . '"');
                    }
                }
                
                $request = $res;
            }
        }
        return $request;
    }
    
    /**
     * A simple wrapper method around {@link process()} for processing the response.
     *
     * @param Request  $request  The regain\HTTP\Request object
     * @param Response $response The regain\HTTP\Response object
     *
     * @return Response|null {@see process()}
     */
    public function process_response($request, $response) {
        $mws = array_reverse($this->middleware);
        foreach($mws as $mw) {
            if(method_exists($mw, 'process_response')) {
                $res = $mw->process_response($request, $response);
                
                if(!$res instanceof Response) {
                    throw new TypeException('The process_response method expects a Response object in return. "' . get_class($mw) . '" return an object of type "' . gettype($res) . '"');
                }
                
                $request = $res;
            }
        }
        return $request;
    }
}