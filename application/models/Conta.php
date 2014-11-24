<?php

class Conta extends Zend_Db_Table_Abstract {

    protected $_name = 'conta';
    protected $_dependentTables = array('ExtratoConta');

}
