<?php

namespace regain\Middleware;

use regain\Middleware\Base
  , regain\HTTP\ResponseRedirect
  , regain\Settings
  ;

class Common extends Base {
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