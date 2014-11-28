<?php

class Webagille_Plugins_CheckAcl extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        $module = $request->getModuleName();
        $resource = $request->getControllerName();
        $action = $request->getActionName();

        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('usuario'));

        if (!$auth->hasIdentity() && $resource != 'auth') {
            $this->redirectIndex($request);
        }
    }

    public function redirect($request) {
        $request->setModuleName('default')
                ->setControllerName('error')
                ->setActionName('access-denied');
    }

    public function redirect404($request) {
        $request->setModuleName('default')
                ->setControllerName('error')
                ->setActionName('page-not-found');
    }

    public function redirectIndex($request) {
        $request->setModuleName('default')
                ->setControllerName('auth')
                ->setActionName('index');
    }

}
