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

}
