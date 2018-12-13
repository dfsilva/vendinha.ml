<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize() {
        \Phalcon\Tag::prependTitle('Vendinha.ml ');
        $this->view->navBarTitle = "Vendinha";
    }


}
