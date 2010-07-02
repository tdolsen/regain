<?php

namespace regain\Settings;

class Settings {
    private static $settings;

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
        }
    }

    public function __get($key) {
        return self::get($key);
    }
}
