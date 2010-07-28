<?php

namespace regain;

use regain\Exceptions\Exception;

class Settings {
    private static $settings;

    public function __construct($settings = null) {
        self::setup();
        if(is_array($settings)) {
            self::update($settings);
        }
    }

    private static function setup() {
        if(!isset(self::$settings)) {
            require 'regain/global_settings.php';
            self::$settings = $settings;
        }
    }

    public static function update(array $settings) {
        self::setup();
        self::$settings = array_merge(self::$settings, $settings);
    }

    public static function get($key) {
        if(isset(self::$settings[$key])) {
            return self::$settings[$key];
        } else {
            throw new Exception('No setting with key "' . $key . '".');
        }
    }

    public function __get($key) {
        return self::get($key);
    }

    public function __isset($key) {
        return isset(self::$settings[$key]);
    }
}
