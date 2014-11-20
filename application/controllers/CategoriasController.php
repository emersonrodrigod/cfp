<?php

class CategoriasController extends Zend_Controller_Action {

    public function indexAction() {
        $categoria = new Categoria();
        $this->view->categorias = $categoria->fetchAll('id_pai is null','tipo desc');
    }

    public function addAction() {
        $categoria = new Categoria();
        $this->view->categorias = $categoria->fetchAll('id_pai is null');

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            if ($data['id_pai'] == '') {
                unset($data['id_pai']);
            }

            try {
                $categoria->insert($data);
                $this->_helper->flashMessenger(array('success' => 'Categoria adicionada com sucesso!'));
                $this->redirect("/categorias");
            } catch (Zend_Db_Exception $e) {
                $this->_helper->flashMessenger(array('error' => 'Desculpe, ocorreu um erro: ' . $e->getMessage()));
            }
        }
    }

    public function editAction() {
        $categoria = new Categoria();
        $this->view->categorias = $categoria->fetchAll('id_pai is null');

        $atual = $categoria->find($this->getParam('id'))->current();
        $this->view->categoria = $atual;

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            if ($data['id_pai'] == '') {
                unset($data['id_pai']);
            }

            try {
                $atual->nome = $data['nome'];
                $atual->id_pai = $data['id_pai'];
                $atual->tipo = $data['tipo'];
                
                $atual->save();
                $this->_helper->flashMessenger(array('success' => 'Categoria Alterada com sucesso!'));
                $this->redirect("/categorias");
            } catch (Zend_Db_Exception $e) {
                $this->_helper->flashMessenger(array('error' => 'Desculpe, ocorreu um erro: ' . $e->getMessage()));
            }
        }
    }

}
