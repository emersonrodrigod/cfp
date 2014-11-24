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
            return $this->fetchAll("MONTH(vencimento) = $mes and YEAR(vencimento) = $ano " . $this->montaFiltro($filtros));
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

    public function adicionar(array $data, $tipo, $parcelas, $periodicidade) {
        $data['parcelas'] = $parcelas;
        $data['numeroParcela'] = 1;

        if ($tipo == 0) {


            $idLancamento = $this->insert($data);

            if ($data['situacao'] == 1) {

                if ($data['tipo'] == 'D') {
                    $data['valor'] = $data['valor'] * -1;

                    $historico = "Pagamento referente a " . $data['titulo'];
                } else {
                    $historico = "Recebimento referente a " . $data['titulo'];
                }


                $dadosExtrato = array(
                    'id_conta' => $data['id_conta'],
                    'valor' => $data['valor'],
                    'id_lancamento' => $idLancamento,
                    'historico' => $historico
                );

                $this->adicionarExtrato($dadosExtrato);
            }
        }

        if ($tipo == 1) {

            $data['valor'] = $data['valor'] / $parcelas;
            $data['situacao'] = 0;

            for ($i = 1; $i <= $parcelas; $i++) {

                $data['numeroParcela'] = $i;

                $vencimento = new Zend_Date(Util::dataToText($data['vencimento']));
                if ($i > 1) {

                    if ($periodicidade == 0) {
                        $vencimento->addDay(1);
                    }

                    if ($periodicidade == 1) {
                        $vencimento->addMonth(1);
                    }

                    if ($periodicidade == 2) {
                        $vencimento->addYear(1);
                    }

                    $data['vencimento'] = $vencimento->get(Zend_Date::YEAR_8601) . '-' . $vencimento->get(Zend_Date::MONTH) . '-' . $vencimento->get(Zend_Date::DAY);
                }

                $this->insert($data);
            }
        }

        if ($tipo == 2) {
            $data['situacao'] = 0;
            $vencimento = new Zend_Date(Util::dataToText($data['vencimento']));
            for ($i = 1; $i <= 6; $i++) {
                if ($i > 1) {

                    if ($periodicidade == 0) {
                        $vencimento->addDay(1);
                    }

                    if ($periodicidade == 1) {
                        $vencimento->addMonth(1);
                    }

                    if ($periodicidade == 2) {
                        $vencimento->addYear(1);
                    }

                    $data['vencimento'] = $vencimento->get(Zend_Date::YEAR_8601) . '-' . $vencimento->get(Zend_Date::MONTH) . '-' . $vencimento->get(Zend_Date::DAY);
                }

                $this->insert($data);
            }
        }
    }

    public function adicionarExtrato($dados) {
        $extrato = new ExtratoConta();
        $extrato->insert($dados);
    }

    public function pagar($idLancamento) {
        $atual = $this->find($idLancamento)->current();

        $atual->dataPagamento = date("Y-m-d");
        $atual->situacao = 1;
        $atual->save();

        if ($atual->tipo == 'D') {
            $valor = $atual->valor * -1;

            $historico = "Pagamento referente a " . $atual->titulo;
        } else {
            $historico = "Recebimento referente a " . $atual->titulo;
        }

        $dadosExtrato = array(
            'id_conta' => $atual->id_conta,
            'valor' => $valor,
            'id_lancamento' => $idLancamento,
            'historico' => $historico
        );

        $this->adicionarExtrato($dadosExtrato);
    }

}
