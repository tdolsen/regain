<?php

namespace regain\Middleware;

/**
 * Interface all middleware classes must implement.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
interface MiddlewareInterface {
    /**
     * Processes the request object before it's passed to the view. The $request
     * parameter can be manipulated, as it passed by reference. If one would want
     * to stop futher processing, and go stright to output, the function should
     * return a response obejct.
     *
     * @param  regain\HTTP\Request &$request The request objects, passed by reference
     * 
     * @return mixed Should return either null, or a regain\HTTP\Response object
     *               to be submitted directly to output
     */
    public function process_request(&$request);
    
    /**
     * Processes the response object after the view is run. The $response parameter
     * can be manipulated, as it is passed by reference. If one would want to stop
     * futher processing, and go stright to output, the function should return a
     * response obejct.
     *
     * @param regain\HTTP\Request  $request The request object, for reference
     * @param regain\HTTP\Response &$reponse The response object, passed by reference
     *
     * @return mixed Should return either null, or a regain\HTTP\Response object
     *               to be submitted directly to output
     */
    public function process_response($request, &$response);
}