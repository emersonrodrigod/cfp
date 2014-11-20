<?php

class Lancamento extends Zend_Db_Table_Abstract {

    protected $_name = 'lancamento';
    protected $_rowClass = 'LancamentoRow';
    protected $_referenceMap = array(
        'Categoria' => array(
            'refTableClass' => 'Categoria',
            'refColumns' => array('id'),
            'columns' => array('id_categoria')
        ),
        'SubCategoria' => array(
            'refTableClass' => 'Categoria',
            'refColumns' => array('id'),
            'columns' => array('id_subcategoria')
        ),
        'Conta' => array(
            'refTableClass' => 'Conta',
            'refColumns' => array('id'),
            'columns' => array('id_conta')
        )
    );

    public function lista($mes, $ano, array $filtros = null) {
        if (is_null($filtros)) {
            return $this->fetchAll("MONTH(vencimento) = $mes and YEAR(vencimento) = $ano");
        }
    }

    public function getTotalDespesasMes($mes, $ano, $situacao, array $filtros = null) {
        if (is_null($filtros)) {

            if ($filtros == null) {
                $select = $this->select()
                        ->from('lancamento', array('despesas' => 'SUM(valor)'))
                        ->where(
                        "tipo = 'D' and situacao = $situacao and MONTH(vencimento) = $mes and YEAR(vencimento) = $ano"
                );
            }

            return $this->fetchRow($select)->toArray();
        }
    }

    public function getTotalReceitasMes($mes, $ano, $situacao, array $filtros = null) {
        if (is_null($filtros)) {

            if ($filtros == null) {
                $select = $this->select()
                        ->from('lancamento', array('receitas' => 'SUM(valor)'))
                        ->where(
                        "tipo = 'R' and situacao = $situacao and MONTH(vencimento) = $mes and YEAR(vencimento) = $ano"
                );
            }

            return $this->fetchRow($select)->toArray();
        }
    }

    public function getSaldoAnterior($mes, $ano) {
        $selectReceitas = $this->select()
                ->from('lancamento', array('receitas' => 'SUM(valor)'))
                ->where(
                "tipo = 'R' and situacao = 1 and MONTH(vencimento) < $mes and YEAR(vencimento) <= $ano"
        );

        $selectDespesas = $this->select()
                ->from('lancamento', array('despesas' => 'SUM(valor)'))
                ->where(
                "tipo = 'D' and situacao = 1 and MONTH(vencimento) < $mes and YEAR(vencimento) <= $ano"
        );

        $totalReceitas = $this->fetchRow($selectReceitas)->toArray()['receitas'];
        $totalDespesas = $this->fetchRow($selectDespesas)->toArray()['despesas'];

        return $totalReceitas - $totalDespesas;
    }

}
