<?php

namespace regain\Template;

/**
 * The interface defining the required methods for template objects.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
interface TemplateInterface {
    /**
     * The constructor, for setting up the real template.
     *
     * @param mixed $template A reference to the acutal template object
     *
     * @return null
     */
    public function __construct($template);

    /**
     * The method responsible for rendering the template.
     *
     * @param mixed $data A collection of variable information to insert in the template
     *
     * @return string
     */
    public function render($data);
}
