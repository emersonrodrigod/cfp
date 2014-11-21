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
        } else {
            return $this->fetchAll("MONTH(vencimento) = $mes and YEAR(vencimento) = $ano ". $this->montaFiltro($filtros));
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
        date_default_timezone_set('America/Sao_Paulo');
        Zend_Date::setOptions(array('extend_month' => true));
        $d = '01/' . $mes . '/' . $ano;
        $data = new Zend_Date($d);
        $data->subDay(1);
        $final = $data->get(Zend_Date::YEAR_8601) . '-' . $data->get(Zend_Date::MONTH) . '-' . $data->get(Zend_Date::DAY);

        $selectReceitas = $this->select()
                ->from('lancamento', array('receitas' => 'SUM(valor)'))
                ->where(
                "tipo = 'R' and situacao = 1 and vencimento <= '$final'"
        );

        $selectDespesas = $this->select()
                ->from('lancamento', array('despesas' => 'SUM(valor)'))
                ->where(
                "tipo = 'D' and situacao = 1 and vencimento <= '$final'"
        );

        $totalReceitas = $this->fetchRow($selectReceitas)->toArray()['receitas'];
        $totalDespesas = $this->fetchRow($selectDespesas)->toArray()['despesas'];

        return $totalReceitas - $totalDespesas;
    }

    private function montaFiltro(array $filtros) {

        $where = '';

        if ($filtros['tipo'] != '') {
            $where .= " and tipo = '" . $filtros['tipo'] . "'";
        }
        
        
        if ($filtros['categoria'] != '') {
            $where .= " and id_categoria = " . $filtros['categoria'];
        }
        
        if ($filtros['situacao'] != '') {
            $where .= " and situacao = " . $filtros['situacao'];
        }
        
        if ($filtros['caixa'] != '') {
            $where .= " and id_conta = " . $filtros['caixa'];
        }
        

        return $where;
    }

}
