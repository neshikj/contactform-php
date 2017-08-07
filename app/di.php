<?php
/**
 * File is consumed when the app is being loaded.
 *
 * These definitions will be available in the app's controllers etc.
 */

use ContactForm\Controllers\FormController;
use ContactForm\Controllers\FormCreateController;
use ContactForm\Controllers\FormCreateAJAXController;
use ContactForm\Helpers\InputHandler;

return [
    'mailgun-config' => 'Oye',
    'FormController' => function() {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/../src/ContactForm/Views');
        $controller = new FormController(new Twig_Environment($loader));
        return $controller->process();
    },

    'FormCreateController' => function() {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/../src/ContactForm/Views');
        $controller = new FormCreateController(new Twig_Environment($loader), new InputHandler());
        return $controller->process();
    },

    'FormCreateAJAXController' => function() {
        $controller = new FormCreateAJAXController(new InputHandler());
        return $controller->process();
    }
];
