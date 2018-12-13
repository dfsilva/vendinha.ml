<?php

class VendaController extends ControllerBase
{

    public function initialize() {
        parent::initialize();
    }

    public function indexAction()
    {

    }

    public function produtosAction()
    {
        \Phalcon\Tag::setTitle(' - Venda Produtos facilmente para pessoas que estão próximo a você.');
        $date = new DateTime();
        $this->getDI()->get('log')->info('Index Action ');
        $this->view->hello = "hey, hello! " . $date->format('Y-m-d H:i:s');
        $this->view->navBarTitle = "Vender um Produto";
    }
}
