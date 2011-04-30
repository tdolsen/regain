<?php

namespace regain;

use regain\Settings
  , regain\Exceptions\TemplateImportException
  , regain\Exceptions\TypeException
  , regain\Template\EngineInterface
  , regain\Template\TemplateInterface
  ;

/**
 * The generic template class, representing a single template, but also automatically
 * handles the template engine defined in the settings.
 *
 * @author     Torkild Dyvik Olsen <torkild@tdolsen.net>
 * @package    regain
 */
class Template {
    /**
     * The variable to hold the engine. Is set on first instanciation in
     * {@link __contsruct}, and only referenced later.
     *
     * @var $engine mixed
     */
    static protected $engine;

    /**
     * A variable holding a reference to the template the current instance represent.
     *
     * @var $template mixed
     */
    protected $template;

    /**
     * The contstructor, setting up the {@link $engine} on first run, and the
     * {@link $template} on each run.
     *
     * @param string $template The template to load
     *
     * @return null
     */
    public function __construct($template) {
        if(!isset($this->engine)) {
            $settings = new Settings();
            $engine = $settings->get('template_engine');
            $engine = new $engine($settings);

            if(!$engine instanceof EngineInterface) {
                throw new TypeException('The template engine must be an instance of the regain\Template\Engine abstract class. Alternativly a wrapper class.');
            }

            self::$engine = $engine;
        }

        $template = self::$engine->load_template(ltrim($template, '/'));

        if(!$template instanceof TemplateInterface) {
            throw new TypeException('The template returned by the engine must be an instance of the regain\Template\Template abstract class.');
        }

        $this->template = $template;
    }

    /**
     * A simple wrapper function to render the template. Simply calls on the
     * referenced templates render method. Takes one parameter and passes it
     * along, representing variable data to insert into the template.
     *
     * Since different engines require different data types, no validation is done.
     *
     * @param mixed $data The variable data to pass to the template
     *
     * @return string Must return a string or an object able to cast to string
     */
    public function render($data) {
        return $this->template->render($data);
    }
}
