<?php

namespace regain;

use regain\HTTP\Response
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
            $mw = new $mw();
            
            if(!$mw instanceof MiddlewareInterface) {
                throw new TypeException('All middleware classes need to be an instance of "regain\Middleware\Skeleton".');
            }
            
            $this->middleware[] = $mw;
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
    private function process($action, &$request, &$response = null) {
        $action = 'process_' . $action;
        
        foreach($this->middleware as $mw) {
            // Only if the middleware has the action
            if(method_exists($mw, $action)) {
                $res = $mw->$action($request, $response);
                
                if($res != null) {
                    if(!$res instanceof Response) {
                        throw new TypeException('The middleware class "' . get_class($mw) . '" returned an unknown result for "process_' . $action . '". Must return an instance of HTTP\Response or null.');
                    }
                    
                    return $res;
                }
            }
        }
    }
    
    /**
     * A simple wrapper method around {@link process()} for processing the request.
     *
     * @param Request &$request The regain\HTTP\Request object
     *
     * @return Response|null {@see process()}
     */
    public function process_request(&$request) {
        return $this->process('request', $request);
    }
    
    /**
     * A simple wrapper method around {@link process()} for processing the response.
     *
     * @param Request $request    The regain\HTTP\Request object
     * @param Response &$response The regain\HTTP\Response object
     *
     * @return Response|null {@see process()}
     */
    public function process_response($request, &$response) {
        return $this->process('response', $request, $response);
    }
}