<?php

namespace regain\Middleware;

use regain\Middleware\MiddlewareAbstract
  , regain\HTTP\ResponseRedirect
  , regain\Settings
  ;

/**
 * A middleware class representing common behaviour for an application.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class Common extends MiddlewareAbstract {
    /**
     * Processes common response behaviours. Currently does the following:
     * - Appends a forward slash after the path name
     *
     * All behaviour can be modified in settings
     *
     * @param regain\HTTP\Request  $request
     * @param regain\HTTP\response &$response
     *
     * @return mixed
     */
    public function process_response($request, &$response) {
        // Appends a forward slash if set in the settings
        if(Settings::get('append_slash')) {
            if($response->status == 404 and substr($request->path, -1, 1) != '/') {
                // TODO: How to handle POST request, as they can't be redirected
                $path = Settings::get('absolute_path_prefix') . '/' . $request->path . '/';
                
                if($request->query_string != '') {
                    $path.= '?' . $request->query_string;
                }
                
                return new ResponseRedirect($path);
            }
        }
    }
}