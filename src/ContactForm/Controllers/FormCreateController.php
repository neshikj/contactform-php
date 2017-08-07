<?php
namespace ContactForm\Controllers;

use Twig_Environment;
use ContactForm\Helpers\InputHandler;
use ContactForm\Models\Question;

class FormCreateController implements ControllerInterface {

    /**
     * @param Twig_Environment $twig
     */
    private $twig;

    /**
     * @var InputHandler $inputHandler
     */
    private $inputHandler;

    public function __construct(Twig_Environment $twig, InputHandler $inputHandler) {
        $this->twig = $twig;
        $this->inputHandler = $inputHandler;
    }

    public function process()
    {
        $res = $this->inputHandler->run(new Question());

        // Check if there are validation errors returned
        if ($res['status'] == 0) {
            echo $this->twig->render('form.twig', $res);
        } else {
            echo $this->twig->render('formSent.twig');
        }
    }
}