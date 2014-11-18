<?php

class ContasController extends Zend_Controller_Action {

    public function indexAction() {
        $conta = new Conta();
        $this->view->contas = $conta->fetchAll();
    }

    public function addAction() {
        if ($this->getRequest()->isPost()) {
            $conta = new Conta();
            $data = $this->getRequest()->getPost();

            try {
                $conta->insert($data);
                $this->_helper->flashMessenger(array('success' => 'Conta adicionada com sucesso!'));
                $this->redirect("/contas");
            } catch (Zend_Db_Exception $e) {
                $this->_helper->flashMessenger(array('error' => 'Desculpe, ocorreu um erro: ' . $e->getMessage()));
            }
        }
    }

    public function editAction() {
        $conta = new Conta();
        $atual = $conta->find($this->getParam('id'))->current();
        $this->view->conta = $atual;

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            $atual->nome = $data['nome'];
            $atual->descricao = $data['descricao'];

            try {
                $atual->save();
                $this->_helper->flashMessenger(array('success' => 'Conta alterada com sucesso!'));
                $this->redirect("/contas");
            } catch (Zend_Db_Exception $e) {
                $this->_helper->flashMessenger(array('error' => 'Desculpe, ocorreu um erro: ' . $e->getMessage()));
            }
        }
    }

}
