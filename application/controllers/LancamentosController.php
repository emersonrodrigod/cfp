<?php

class LancamentosController extends Zend_Controller_Action {

    public function indexAction() {
        
    }

    public function carregaAction() {
        $this->_helper->layout()->disableLayout();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            //print_r($data);
        }
    }

}
