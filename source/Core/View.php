<?php


namespace Source\Core;


use League\Plates\Engine;

class View
{

    /*** @var */
    private $engine;

    /*** @var */
    public $path;

    /*** @var */
    public $extension;

    /**
     * View constructor. Responsible for initiating Engine from League Plates.
     * @param string $path
     * @param string $ext
     */
    public function __construct(string $path = __DIR__."/../../".CONF_THEME_WEB, string $ext = CONF_THEME_EXT)
    {
        $this->engine = new Engine($path, $ext);
    }

    /**
     * Add a new folder to template Engine.
     * @param string $name
     * @param string $path
     * @return $this|Engine
     */
    public function path(string $name, string $path): Engine
    {
        $this->engine->addFolder($name, $path);
        return $this;
    }

    /**
     * Responsible for rendering a template.
     * @param string $templateName
     * @param array $data
     * @return string
     */
    public function render(string $templateName, array $data): string
    {
        return $this->engine->render($templateName, $data);
    }

    /**
     * @return Engine
     */
    public function engine(): Engine
    {
        return $this->engine;
    }

}