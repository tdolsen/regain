<?php

namespace regain\HTTP;

class Request {
    protected $data;

    public function __construct() {
        $data = array();

        $data['path'] = 'tab/item/blue-blabla/';

        $this->data = $data;
    }

    public function __get($key) {
        return $this->data[$key];
    }
}
