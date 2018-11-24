<?php

namespace Vendinha\Site\Controllers;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
//        $this->view->setTemplateAfter('index/index_after');

//        $this->view->templateAfter = 'index/index_after';
    }

    public function testAction()
    {
        $this->view->hello = "hey, hello!";
    }
}
