<?php

class ExtratoConta extends Zend_Db_Table_Abstract {

    protected $_name = 'extrato_caixa';
    protected $_referenceMap = array(
        'Conta' => array(
            'refTableClass' => 'Conta',
            'refColumns' => array('id'),
            'columns' => array('id_conta')
        ),
        'Lancamento' => array(
            'refTableClass' => 'Lancamento',
            'refColumns' => array('id'),
            'columns' => array('id_lancamento')
        )
    );

}
