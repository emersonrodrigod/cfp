<?php

class Categoria extends Zend_Db_Table_Abstract {

    protected $_name = 'categoria';
    protected $_rowClass = 'CategoriaRow';
    protected $_dependentTables = array('Categoria','Lancamento');
    protected $_referenceMap = array(
        'Categoria' => array(
            'refTableClass' => 'Categoria',
            'refColumns' => array('id'),
            'columns' => array('id_pai')
        )
    );

}
