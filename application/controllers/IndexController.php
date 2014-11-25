<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $conta = new Conta();
        $this->view->contas = $conta->fetchAll();
    }

}
