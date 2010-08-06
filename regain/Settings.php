<?php

namespace regain;

use regain\Exceptions\Exception;

/**
 * A simple class to handle global and applicaiton spesific settings.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class Settings {
    /**
     * The array holding on to all settings.
     *
     * @var $settings array
     */
    private static $settings;
    
    /**
     * The constructor, simply handeling instanciation and adding additional settings.
     *
     * Calls {@link setup()} at each call.
     *
     * @param array $settings An optional array for overriding the global settings
     *
     * @return null
     */
    public function __construct(array $settings = null) {
        self::setup();
        if(is_array($settings)) {
            self::update($settings);
        }
    }
    
    /**
     * A method making sure the global settings are loaded and at first call.
     *
     * @return null
     */
    private static function setup() {
        if(!isset(self::$settings)) {
            require 'regain/global_settings.php';
            self::$settings = $settings;
        }
    }
    
    /**
     * Updates the settings array with keys in given array.
     *
     * @param array $settings An associative array representing settings to be updated.
     *
     * @return null
     */
    public static function update(array $settings) {
        self::setup();
        self::$settings = array_merge(self::$settings, $settings);
    }
    
    /**
     * Gets a value in the settings, with an optional fallback if the setting is
     * unset. If setting is unset an no fallback is set, throws an exception.
     *
     * @param string $key     The setting to lookup
     * @param mixed $fallback A value to return in case the setting is unset
     *
     * @return mixed The setting or fallback
     */
    public static function get($key, $fallback = null) {
        if(isset(self::$settings[$key])) {
            return self::$settings[$key];
        } elseif(isset($fallback)) {
            return $fallback;
        } else {
            // TODO: Throw a more suitable exception
            throw new Exception('No setting with key "' . $key . '".');
        }
    }
    
    /**
     * Magic __get method, remapping to {@link get()}. No fallback is possible.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key) {
        return self::get($key);
    }
    
    /**
     * Magic __isset method for cheking if a setting is set.
     *
     * @param string $key The setting to check
     *
     * @return boolean
     */
    public function __isset($key) {
        return isset(self::$settings[$key]);
    }
}
