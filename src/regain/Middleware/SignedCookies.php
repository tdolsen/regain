<?php

namespace regain\Middleware;

use regain\Settings;

class SignedCookies {
    protected $key;
    
    public function __construct() {
        $this->key = Settings::get('secret_key');
    }
    
    protected function sign($key, $value) {
        return $this->get_hash($key, $value) . ':' . $value;
    }
    
    protected function unsign($key, $value) {
        try {
            list($hash, $value) = explode(':', $value, 2);
            return $this->get_hash($key, $value) == $hash ? $value : false;
        } catch(\Exception $e) {
            return false;
        }
    }
    
    protected function get_hash($key, $value) {
        return sha1($this->key . $value . $key);
    }
    
    public function process_request($request) {
        $cookies = $request->cookies;
        foreach($cookies as $key => $value) {
            if($value = $this->unsign($key, $value)) {
                $cookies[$key] = $value;
            } else {
                // Sucpicious activity, so unset the cookie. It's not generated on the server.
                unset($cookies[$key]);
            }
        }
        
        $request->cookies = $cookies;
        
        return $request;
    }
    
    public function process_response($request, $response) {
        $time = time();
        $cookies = $response->cookies;
        
        foreach($cookies as $key => $morsel) {
            if($morsel['expires'] != 0 and $morsel['expires'] <= $time) {
                continue;
            }
            
            $morsel['value'] = $this->sign($key, $morsel['value']);
            $cookies[$key] = $morsel;
        }
        
        $response->cookies = $cookies;
        
        return $response;
    }
}