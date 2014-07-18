<?php

namespace Utils\Mvc\Controller;

//use Utils\Mvc\Models\ModelResult
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class TfdController extends AbstractActionController {

    protected $storage;
    protected $authservice;

    public function __construct() {
        
    }

     public function onDispatch(Zend\Mvc\MvcEvent $e) {
        // check authentication here
        exit('in dispatch');
        return parent::onDispatch($e);
    }
    public function getAuthService() {
        if (!$this->authservice) {

            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'user', 'email', 'password', 'MD5(?)');

            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);

            $this->authservice = $authService;
        }

        return $this->authservice;
    }

}
