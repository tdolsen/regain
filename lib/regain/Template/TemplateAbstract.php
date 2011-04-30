<?php

namespace regain\Template;

use regain\Template\TemplateInterface;

/**
 * An abstract class defining the required method for an adapter template class.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
abstract class TemplateAbstract implements TemplateInterface {
    /**
     * The variable holding the reference to the acutuall template class.
     *
     * @var $template mixed
     */
    protected $template;

    /**
     * A simple standard behaviour for accepting and storing the template.
     *
     * @param mixed $template A reference to the acctuall template class
     *
     * @return null
     */
    public function __construct($template) {
        $this->template = $template;
    }
}
