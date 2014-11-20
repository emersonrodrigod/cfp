<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initAutoLoader() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);
    }

    public function _initViews() {
        $currency = new Zend_Currency('pt_BR');
        $currency->setFormat(array('symbol' => " R$ "));
        Zend_Registry::set('currency', $currency);
    }

    public function _initMes() {
        date_default_timezone_set('America/Sao_Paulo');
        Zend_Date::setOptions(array('extend_month' => true));
        $data = new Zend_Date();

        $mes = $data->get(Zend_Date::MONTH);
        $ano = $data->get(Zend_Date::YEAR_8601);

        $storage = new Zend_Session_Namespace('data');

        if (!isset($storage->mes)) {
            $storage->mes = $mes;
            $storage->ano = $ano;
        }
    }

}
