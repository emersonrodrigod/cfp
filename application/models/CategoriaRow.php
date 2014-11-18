<?php

class CategoriaRow extends Zend_Db_Table_Row_Abstract {

    public function getChildrens() {
        $childrens = $this->findDependentRowset('Categoria');
        return $childrens;
    }

}
