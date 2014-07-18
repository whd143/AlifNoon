<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Authentication;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

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
            $controllerName = $controller->getEvent()->getRouteMatch()->getParam('controller');
            if (!in_array($controllerName, array('Authentication\Controller\Index',
                    ))) {
                $controller->layout('layout/admin-layout');
            }
        });

        /**
         * Do this event when dispatch is triggered, whith highest priority==1
         */
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, function (MvcEvent $event) {
            /**
             * We don't have to redirect if we are in a 'public' area, so don't even try        
             */
            $controller = $event->getTarget(); /* The controller which is dispatched */
            $controllerName = $controller->getEvent()->getRouteMatch()->getParam('controller');
            //$event->getRouteMatch()->getMatchedRouteName() === 'authentication'
            /**
             * If user session is available then simply redirect the user to dashboard, while 
             * He is trying to access the unrestriced area like login/forgot password pages
             */
            if ($controllerName == "Authentication\Controller\Index") {
                $response = $event->getResponse();
                if ($event->getApplication()->getServiceManager()->get('AuthService')->isAuthenticated() === true) {
                    $response->getHeaders()->clearHeaders()->addHeaderLine('Location', '/admin/dashboard');
                    $response->setStatusCode(200)->sendHeaders();
                    exit;
                } else {
                    return;
                }
            }

            /**
             * if user is trying to access the restricted without logged in, then simply redirect him to login page
             */
            if ($event->getApplication()->getServiceManager()->get('AuthService')->isAuthenticated() === false) {
                /* Get the response from the event */
                $response = $event->getResponse();
                /**
                 * redirection: Clear current headers and add our Location to login page 
                 */
                $response->getHeaders()->clearHeaders()->addHeaderLine('Location', '/admin');
                /**
                 *  Set the status code to redirect
                 */
                $response->setStatusCode(302)->sendHeaders();
                exit;
            }
        },
                /**
                 * Execute this event with highest priority==1
                 */ 1);
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
            'abstract_factories' => array(),
            'aliases' => array(),
            'factories' => array(
                // DB
            /*    'EmployeeTable' => function($sm) {
            $tableGateway = $sm->get('EmployeeTableGateway');
            $table = new \Authentication\Gateway\EmployeeTable($tableGateway);
            return $table;
        },
                'EmployeeTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new \Authentication\Model\Employee());
            return new TableGateway('employee', $dbAdapter, null, $resultSetPrototype);
        },*/
            /* 'UploadTable' => function($sm) {
              $tableGateway = $sm->get('UploadTableGateway');
              $uploadSharingTableGateway = $sm->get('UploadSharingTableGateway');
              $table = new UploadTable($tableGateway, $uploadSharingTableGateway);
              return $table;
              },
              'UploadTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new Upload());
              return new TableGateway('uploads', $dbAdapter, null, $resultSetPrototype);
              },
              'UploadSharingTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              return new TableGateway('uploads_sharing', $dbAdapter);
              },
              'ChatMessagesTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              return new TableGateway('chat_messages', $dbAdapter);
              },
              'ImageUploadTable' => function($sm) {
              $tableGateway = $sm->get('ImageUploadTableGateway');
              $table = new ImageUploadTable($tableGateway);
              return $table;
              },
              'ImageUploadTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new ImageUpload());
              return new TableGateway('image_uploads', $dbAdapter, null, $resultSetPrototype);
              },
              // DB Store Objects
              'StoreProductsTable' => function($sm) {
              $tableGateway = $sm->get('StoreProductsTableGateway');
              $table = new StoreProductTable($tableGateway);
              return $table;
              },
              'StoreProductsTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new StoreProduct());
              return new TableGateway('store_products', $dbAdapter, null, $resultSetPrototype);
              },
              'StoreOrdersTable' => function($sm) {
              $tableGateway = $sm->get('StoreOrdersTableGateway');
              $productTableGateway = $sm->get('StoreProductsTableGateway');
              $table = new StoreOrderTable($tableGateway, $productTableGateway);
              return $table;
              },
              'StoreOrdersTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new StoreOrder());
              return new TableGateway('store_orders', $dbAdapter, null, $resultSetPrototype);
              },
              // FORMS
              'LoginForm' => function ($sm) {
              $form = new \Users\Form\LoginForm();
              $form->setInputFilter($sm->get('LoginFilter'));
              return $form;
              },
              'RegisterForm' => function ($sm) {
              $form = new \Users\Form\RegisterForm();
              $form->setInputFilter($sm->get('RegisterFilter'));
              return $form;
              },
              'UserEditForm' => function ($sm) {
              $form = new \Users\Form\UserEditForm();
              $form->setInputFilter($sm->get('UserEditFilter'));
              return $form;
              },
              'UploadForm' => function ($sm) {
              $form = new \Users\Form\UploadForm();
              return $form;
              },
              'UploadEditForm' => function ($sm) {
              $form = new \Users\Form\UploadEditForm();
              return $form;
              },
              'UploadShareForm' => function ($sm) {
              $form = new \Users\Form\UploadShareForm();
              return $form;
              },
              'ImageUploadForm' => function ($sm) {
              $form = new \Users\Form\ImageUploadForm();
              $form->setInputFilter($sm->get('ImageUploadFilter'));
              return $form;
              },
              'MultiImageUploadForm' => function ($sm) {
              $form = new \Users\Form\MultiImageUploadForm();
              return $form;
              },
              // FILTERS
              'LoginFilter' => function ($sm) {
              return new \Users\Form\LoginFilter();
              },
              'RegisterFilter' => function ($sm) {
              return new \Users\Form\RegisterFilter();
              },
              'UserEditFilter' => function ($sm) {
              return new \Users\Form\UserEditFilter();
              },
              'ImageUploadFilter' => function ($sm) {
              return new \Users\Form\ImageUploadFilter();
              }, */
            ),
            'invokables' => array(),
            'services' => array(),
            'shared' => array(),
        );
    }

}
