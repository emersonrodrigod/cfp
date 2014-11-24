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
        $storage = new Zend_Session_Namespace('data');
        $storage->mes = date("m");
        $storage->ano = date("Y");

        $this->_mes = $storage->mes;
        $this->_ano = $storage->ano;

        $this->view->mes = Util::mesExtenso($this->_mes);
        $this->view->ano = $this->_ano;

        $categoria = new Categoria();
        $this->view->categorias = $categoria->fetchAll('id_pai is null', 'tipo desc');

        $conta = new Conta();
        $this->view->contas = $conta->fetchAll();
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
            $this->view->lancamentos = $lancamento->lista($this->_mes, $this->_ano, $data);
        }
    }

    public function addAction() {
        $categoria = new Categoria();
        $this->view->categorias = $categoria->fetchAll("id_pai is null and tipo = '" . $this->getParam('tipo') . "'");
        $this->view->tipo = $this->getParam('tipo');

        $conta = new Conta();
        $this->view->contas = $conta->fetchAll();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            $dadosLancamento = array(
                'titulo' => $data['titulo'],
                'tipo' => $data['tipo'],
                'id_categoria' => $data['id_categoria'],
                'id_subcategoria' => $data['id_subcategoria'],
                'vencimento' => Util::dataMysql($data['vencimento']),
                'valor' => Util::currencyToMysql($data['valor']),
                'id_conta' => $data['id_conta'],
                'situacao' => $data['situacao']
            );

            if ($data['situacao'] == 1) {
                $dadosLancamento['dataPagamento'] = date("Y-m-d");
            }

            $lancamento = new Lancamento();

            try {
                $lancamento->adicionar($dadosLancamento, $data['pagamento'], $data['parcelas']);
                $this->_helper->flashMessenger(array('success' => 'Lançamento adicionado com sucesso!'));
                $this->redirect("/lancamentos");
            } catch (Zend_Db_Exception $e) {
                $this->_helper->flashMessenger(array('error' => 'Desculpe, ocorreu um erro: ' . $e->getMessage()));
            }
        }
    }

}
