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

use Zend\View\Model\JsonModel;

use \Admin\Helper\ErrorLog;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use \Admin\Model\AuthService;

class Module
{

  protected $employeeTable;
  protected $employeeSessionTable;
  protected $roleTable;
  protected $resourceTable;

  protected $employee;
  protected $acl;

  /*public function onBootstrap(MvcEvent $e)
  {
    $eventManager        = $e->getApplication()->getEventManager();
    $moduleRouteListener = new ModuleRouteListener();
    $moduleRouteListener->attach($eventManager);


    //$eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onRenderError'), 0);
    $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), 0);
    #$eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), 0);
    //$eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'checkACL'));
  }*/
  
  
  
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
        if (!in_array($controllerName, array('Admin\Controller\Index',
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
        if ($controllerName == "Admin\Controller\Index") {
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
  
  
  
  
  
  public function getEmployeeTable($sm) {
    if (!$this->employeeTable) 
      $this->employeeTable = $sm->get('Admin\Gateway\EmployeeTable');
    return $this->employeeTable;
  }
  public function getEmployeeSessionTable($sm) {
    if (!$this->employeeSessionTable) 
      $this->employeeSessionTable = $sm->get('Admin\Gateway\EmployeeSessionTable');
    return $this->employeeSessionTable;
  }
  public function getRoleTable($sm) {
    if (!$this->roleTable) 
      $this->roleTable= $sm->get('Admin\Gateway\RoleTable');
    return $this->roleTable;
  }
  public function getResourceTable($sm) {
    if (!$this->resourceTable)
      $this->resourceTable= $sm->get('Admin\Gateway\ResourceTable');
    return $this->resourceTable;
  }
/*
  public function onDispatch($e) {

    $request      = $e->getRequest();
    $headers      = $request->getHeaders();
    $routeName    = $e->getRouteMatch()->getMatchedRouteName();

    $openRoutes   = array(
      'admin/login',
      'admin/login/check',
      'admin/login/recover'
    );



    if ($headers->has('Authorization')) {
      $token = $headers->get('Authorization')->getFieldValue();
      try {
        
        $sm               = $e->getApplication()->getServiceManager();
        $employeeSession  = $this->getEmployeeSessionTable($sm)
          ->getEmployeeByToken($token);
        
        $this->employee   = $this->getEmployeeTable($sm)
          ->getEmployee($employeeSession->getEmployeeID());

        $aclService = $e->getApplication()->getServiceManager()->get('AclService');
        //$aclService->check($e->getRouteMatch());
      } catch( \Admin\Exception $exception) {

        // no session or no employee

        $response = $e->getResponse();
        $response->setStatusCode($exception->getStatus());

        $jsonModel = new JsonModel(array(
          'errors' => array($exception->getMessage())
        ));
        $e->setResult($jsonModel);
        $e->setViewModel($jsonModel);

      }

    } // no token in headers 
    else {
      if (!in_array($routeName, $openRoutes)) {
        $exception = new \Admin\Exception\TokenException();
        $response = $e->getResponse();
        $response->setStatusCode($exception->getStatus());

        $jsonModel = new JsonModel(array(
          'errors' => array($exception->getMessage())
        ));
        $e->setResult($jsonModel);
        $e->setViewModel($jsonModel);
      } else {
        // trying to login and have yet gotten a token from the server
      }
    }

  }*/
  
  public function onRenderError($e) {
    return $this->onDispatchError($e);
  }

  public function onDispatchError($e) {
    return $this->getJsonModelError($e);  
  }

  public function getJsonModelError($e)
  {

    $error = $e->getError();
    if (!$error) {
        return;
    }

    $jsonArray      = array();
    $response       = $e->getResponse();
    $exception      = $e->getParam('exception');


    // if "TFDException"
    if ( method_exists($exception, 'getStatus')) {
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

    
/*


    public function initACL(MvcEvent $e) {
      $acl    = new Acl();
      
      $sm             = $e->getApplication()->getServiceManager();
      $roleTable      = $this->getRoleTable($sm);
      $resourceTable  = $this->getResourceTable($sm);

      $roles = $roleTable->getRoles(); 
      foreach($roles as $role)
        $acl->addRole(new Role($role['title']));
        
      $resources = $resourceTable->getResources();
      foreach($resources as $resource)
        if (!$acl->hasResource($resource['namespace']))
          $acl->addResource(new Resource($resource['namespace']));

      foreach($roles as $role) {
        $roleResources = $resourceTable->getResourcesByRole($role['role_id']);

        foreach($roleResources as $resource)
          $acl->allow($role['title'], $resource['namespace']);
      }

      $this->acl = $acl;

      $this->checkACL($e);
    }


    public function checkACL(MvcEvent $e) {
      $sm             = $e->getApplication()->getServiceManager();
      $roleTable      = $this->getRoleTable($sm);
      $resourceTable  = $this->getResourceTable($sm);

      $authedEmployee = $sm->get('AuthedEmployeeService');
      $employee       = $authedEmployee->getEmployee();
      
      $userRoles      = $roleTable->getRolesByEmployeeID($employee->getEmployeeID());
      $roles          = array_filter($roleTable->getRoles(),function($role) {
        return $role['is_active'];
      });

      $routeName      = $e->getRouteMatch()->getMatchedRouteName();


      $matches = array();
      preg_match_all("/[a-zA-Z]+/", $routeName, $matches);
      ErrorLog::log($matches);
      ErrorLog::log($routeName);
      exit;

      $acl            = $this->acl;

      $isAllowed      = array_map(function($userRole) use ($acl, $routeName) {
        if (!$acl->hasResource($routeName)) return false;
        return $acl->isAllowed($userRole['title'], $routeName);
      }, $userRoles);

      ErrorLog::log($routeName);
      ErrorLog::log(in_array(false, $isAllowed));
      ErrorLog::log($isAllowed);

      //$config = $sm->get('Config');
      //$routes = $config['router']['routes']



      if(in_array(false, $isAllowed)) {
        $exception = new \Admin\Exception\NotAuthorizedException();
        $response = $e->getResponse();
        $response->setStatusCode($exception->getStatus());

        $jsonModel = new JsonModel(array(
          'errors' => array($exception->getMessage())
        ));
        $e->setResult($jsonModel);
        $e->setViewModel($jsonModel);
      }

    }
*/

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() 
    {
      return array(
        'factories' => array(
          
          'AclService' => function($sm) {
            $aclService = new \Admin\Service\Acl();
            $aclService->setServiceLocator($sm);
            $aclService->init();
            return $aclService;
          },

          'AuthedEmployeeService' => function($sm) {
            $authedEmployee = new \Admin\Service\AuthedEmployee();
            $authedEmployee->setServiceLocator($sm);
            $authedEmployee->init();
            return $authedEmployee;
          },

          'SystemEmailService' => function($sm) {
            $systemEmail = new \Admin\Service\SystemEmail();
            $systemEmail->setServiceLocator($sm);
            return $systemEmail;
          },


          
          'Admin\Model\OrderTable' =>  function($sm) {
            $tableGateway = $sm->get('OrderTableGateway');
            $table = new \Admin\Model\OrderTable($tableGateway);
            return $table;
          },
            
          'OrderTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Order());
            return new TableGateway('order', $dbAdapter, null, $resultSetPrototype);
          },




            
          'Admin\Gateway\EmployeeTable' =>  function($sm) {
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



          'Admin\Gateway\RoleTable' =>  function($sm) {
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



          'Admin\Gateway\ResourceTable' =>  function($sm) {
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




          'Admin\Gateway\DepartmentTable' =>  function($sm) {
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





            
          'Admin\Model\UserTable' =>  function($sm) {
            $tableGateway = $sm->get('AdminUserTableGateway');
            $table = new \Admin\Model\UserTable($tableGateway);
            return $table;
          },
            
          'AdminUserTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\User());
            return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
          },
            
          'Admin\Gateway\EmployeeSessionTable' =>  function($sm) {
            $tableGateway = $sm->get('EmployeeSessionTableGateway');
            $table = new \Admin\Gateway\EmployeeSessionTable($tableGateway);
            return $table;
          },
            
          'EmployeeSessionTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\EmployeeSession());
            return new TableGateway('employee_session', $dbAdapter, null, $resultSetPrototype);
          },
        )
      );
    }
}
