<?php

class IndexController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function testAction()
    {

        $date = new DateTime();

        $this->getDI()->get('log')->info('Index Action ');
        $this->view->hello = "hey, hello! " . $date->format('Y-m-d H:i:s');
    }
}
