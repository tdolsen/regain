<?php

namespace regain\HTTP;

class Request {
    protected $data;

    public function __construct() {
        if(isset($_SERVER['PATH_INFO'])) {
            $uri = array(
                $_SERVER['PATH_INFO']
            );
        } else {
            $uri = explode('?', $_SERVER['REQUEST_URI'], 2);
            if(strtolower(substr($uri[0], 0, 10)) == '/index.php') $uri[0] = substr($uri[0], 10);
        }

        $data = array(
            'path' => ltrim($uri[0], '/'),
            'query_string' => $_SERVER['QUERY_STRING'],
            'method' => $_SERVER['REQUEST_METHOD'],
            'get' => $_GET,
            'post' => $_POST,
            'meta' => $_SERVER
        );

        $this->data = $data;
    }

    public function __get($key) {
        return $this->data[$key];
    }

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }

    public function get_host() {
        throw new \regain\NotImplementedException();
    }

    public function get_full_path() {
        return $this->meta['REQUEST_URI'];
    }

    public function is_ajax() {
        return (
                isset($this->meta['HTTP_X_REQUESTED_WITH'])
                and $this->meta['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
               );
    }

    public function is_secure() {
        return (
                isset($this->meta['HTTPS'])
                and $this->meta['HTTPS'] == 'on'
               );
    }
}
