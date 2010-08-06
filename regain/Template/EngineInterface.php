<?php

namespace regain\Template;

/**
 * The interface defining the required methods for template engine objects.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
interface EngineInterface {
    /**
     * The constructor, getting the settings as the only parameter, for setting
     * up the template engine enviorment.
     *
     * @param regain\Settings $settings The settings object
     *
     * @return null
     */
    public function __construct($settings);
    
    /**
     * A method used for loading a single template. The method must return a object
     * that is an instance of regain\Template\TemplateInterface.
     *
     * @param string $template A string representing the template file to load
     *
     * @return regain\Template\TemplateInterface
     */
    public function load_template($template);
}