<?php
namespace ContactForm\Controllers;

use Twig_Environment;

class FormController implements ControllerInterface {

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function process()
    {
        echo $this->twig->render('form.twig');
    }
}