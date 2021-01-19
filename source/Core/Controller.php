<?php


namespace Source\Core;


use Source\Support\Message;
use Source\Support\Seo;

class Controller
{
    /*** @var*/
    protected $view;

    /*** @var*/
    protected $message;

    /*** @var*/
    protected $seo;

    /**
     * Initiate app controllers
     * Controller constructor.
     * @param string|null $pathToViews
     */
    public function __construct(string $pathToViews = null)
    {
        $this->view = new View($pathToViews);
        $this->seo = new Seo();
        $this->message = new Message();
    }
}