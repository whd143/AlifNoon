<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    protected $employeeTable;
    protected $employeeSessionTable;
    protected $roleTable;
    protected $resourceTable;
    protected $employee;
    protected $acl;

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /**
         * Change the Layout area for restricted area, which only allowed to loggedin users
         */
        $sharedEventManager = $eventManager->getSharedManager(); /* The shared event manager */
        $sharedEventManager->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function($e) {
            $controller = $e->getTarget();/** The controller which is dispatched */
            $controller->layout('layout/admin-layout');
        });
    }

    public function onRenderError($e) {
        return $this->onDispatchError($e);
    }

    public function onDispatchError($e) {
        return $this->getJsonModelError($e);
    }

    public function getJsonModelError($e) {

        $error = $e->getError();
        if (!$error) {
            return;
        }

        $jsonArray = array();
        $response = $e->getResponse();
        $exception = $e->getParam('exception');


        // if "TFDException"
        if (method_exists($exception, 'getStatus')) {
            $response->setStatusCode($exception->getStatus());
            $data = $exception->getData();
            if (!empty($data))
                $jsonArray['errors'] = $exception->getData();
            else
                $jsonArray['errors'] = array($exception->getMessage());
        }
        else {
            //$response->setStatusCode(500);
            // if debug
            if (is_object($exception))
                $jsonArray['errors'] = array($exception->getMessage());
            else
                $jsonArray['errors'] = array('somethings fucky');
            //$response->setStatusCode($exception->getCode());
        }

        $model = new JsonModel($jsonArray);
        $e->setResult($model);
        return $model;
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Admin\Gateway\EmployeeTable' => function($sm) {
            $tableGateway = $sm->get('EmployeeTableGateway');
            $table = new \Admin\Gateway\EmployeeTable($tableGateway);
            return $table;
        },
                'EmployeeTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Employee());
            return new TableGateway('employee', $dbAdapter, null, $resultSetPrototype);
        },
                'Admin\Gateway\RoleTable' => function($sm) {
            $tableGateway = $sm->get('RoleTableGateway');
            $table = new \Admin\Gateway\RoleTable($tableGateway);
            return $table;
        },
                'RoleTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Role());
            return new TableGateway('role', $dbAdapter, null, $resultSetPrototype);
        },
                'Admin\Gateway\ResourceTable' => function($sm) {
            $tableGateway = $sm->get('ResourceTableGateway');
            $table = new \Admin\Gateway\ResourceTable($tableGateway);
            return $table;
        },
                'ResourceTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Resource());
            return new TableGateway('resource', $dbAdapter, null, $resultSetPrototype);
        },
                'Admin\Gateway\DepartmentTable' => function($sm) {
            $tableGateway = $sm->get('DepartmentTableGateway');
            $table = new \Admin\Gateway\DepartmentTable($tableGateway);
            return $table;
        },
                'DepartmentTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Department());
            return new TableGateway('department', $dbAdapter, null, $resultSetPrototype);
        },
            )
        );
    }

}
