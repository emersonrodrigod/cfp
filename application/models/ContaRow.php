<?php

class ContaRow extends Zend_Db_Table_Row_Abstract {

    public function getSaldoAtual() {
        $select = $this->getTable()->select()
                ->from('extrato_caixa', array('total' => 'SUM(valor)'))
                ->where('id_conta = ' . $this->id)
                ->setIntegrityCheck(false);

        $total = $this->getTable()->fetchRow($select)->toArray();
        return $this->saldoInicial + $total['total'];
    }

}
