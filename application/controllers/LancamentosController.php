<?php

class LancamentosController extends Zend_Controller_Action {

    private $_mes = null;
    private $_ano = null;

    public function init() {
        $storage = new Zend_Session_Namespace('data');
        $this->_mes = $storage->mes;
        $this->_ano = $storage->ano;
    }

    public function indexAction() {
        $this->view->mes = Util::mesExtenso($this->_mes);
        $this->view->ano = $this->_ano;
    }

    public function trocaAction() {
        $this->_helper->layout()->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender();
        if ($this->getRequest()->isPost()) {
            $valores = $this->getRequest()->getPost();

            $storage = new Zend_Session_Namespace('data');
            $dataAtual = "01/$storage->mes/$storage->ano";
            date_default_timezone_set('America/Sao_Paulo');
            Zend_Date::setOptions(array('extend_month' => true));
            $data = new Zend_Date($dataAtual);

            if ($valores['valor'] < 0) {
                $data->subMonth(1);
            } else {
                $data->addMonth(1);
            }


            $storage->mes = $data->get(Zend_Date::MONTH);
            $storage->ano = $data->get(Zend_Date::YEAR_8601);

            $retorno = array(
                'mes' => Util::mesExtenso($storage->mes),
                'ano' => $storage->ano
            );

            echo Zend_Json_Encoder::encode($retorno);
        }
    }

    public function carregaAction() {
        $this->_helper->layout()->disableLayout();

        $lancamento = new Lancamento();

        $this->view->lancamentos = $lancamento->lista($this->_mes, $this->_ano);

        $totalDespesas = $lancamento->getTotalDespesasMes($this->_mes, $this->_ano, 1)['despesas'];
        $this->view->totalDespesas = $totalDespesas;

        $previsaoDespesas = $lancamento->getTotalDespesasMes($this->_mes, $this->_ano, 0)['despesas'];
        $this->view->previsaoDespesas = $previsaoDespesas;

        $totalReceitas = $lancamento->getTotalReceitasMes($this->_mes, $this->_ano, 1)['receitas'];
        $this->view->totalReceitas = $totalReceitas;

        $previsaoReceitas = $lancamento->getTotalReceitasMes($this->_mes, $this->_ano, 0)['receitas'];
        $this->view->previsaoReceitas = $previsaoReceitas;

        $saldoAnterior = $lancamento->getSaldoAnterior($this->_mes, $this->_ano);
        $this->view->saldoAnterior = $saldoAnterior;

        $saldoBalanco = $saldoAnterior + $totalReceitas - $totalDespesas;
        $saldoBalancoPrevisto = $previsaoReceitas - $previsaoDespesas;

        $this->view->saldoBalanco = $saldoBalanco;
        $this->view->saldoBalancoPrevisto = $saldoBalancoPrevisto;

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            //print_r($data);
        }
    }

}
