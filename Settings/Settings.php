<?php

namespace regain\Settings;

class Settings {
    private static $settings;

    private static function setup() {
        if(!isset(self::$settings)) {
            self::$settings = array();
        }
    }

    public static function update(array $settings) {
        self::setup();
    }
}
