<?php
namespace ContactForm\Controllers;

use ContactForm\Helpers\InputHandler;
use ContactForm\Models\Question;

class FormCreateAJAXController implements ControllerInterface {

    /**
     * @var InputHandler $inputHandler
     */
    private $inputHandler;

    public function __construct(InputHandler $inputHandler) {
        $this->inputHandler = $inputHandler;
    }

    public function process()
    {
        $res = $this->inputHandler->run(new Question());

        $array = array('status' => $res['status'], 'errors' => $res);
        echo json_encode($array);
    }
}