<?php

class LancamentoRow extends Zend_Db_Table_Row_Abstract {

    public function getCategoria() {
        return $this->findParentRow('Categoria');
    }

    public function getValor() {
        return Zend_Registry::get('currency')->toCurrency($this->valor);
    }

    public function getSituacao() {
        return ($this->situacao == 1 ? "Pago em " . date("d/m/Y",strtotime($this->dataPagamento)) : 'Não Pago');
    }

    public function getLabel() {
        switch ($this->tipo) {
            case "R": return 'label-success';
            case "D": return 'label-danger';
            case "T": return 'label-default';
        }
    }

    public function getLabelSituacao() {
        switch ($this->situacao) {
            case 0: return 'label-danger';
            case 1: return 'label-success';
        }
    }

    public function getValorLabel() {
        switch ($this->tipo) {
            case "R": return 'valorReceita';
            case "D": return 'valorDespesa';
            case "T": return '';
        }
    }

}
