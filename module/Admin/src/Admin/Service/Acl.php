<?php
namespace Admin\Service;

use \Zend\ServiceManager\ServiceLocatorAwareInterface;
use \Zend\ServiceManager\ServiceLocatorInterface;

use Zend\Permissions\Acl\Acl as AccessControlList;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

use \Admin\Helper\ErrorLog;

class Acl implements ServiceLocatorAwareInterface {

  protected $serviceLocator;

  protected $acl; 
  protected $roleTable;
  protected $resourceTable;

  public function setServiceLocator(ServiceLocatorInterface $sl) {
    $this->serviceLocator = $sl;
  }

  public function getServiceLocator() {
    return $this->serviceLocator;
  }
  
  public function getRoleTable() {
    if (!$this->roleTable) { 
      $sm = $this->getServiceLocator();
      $this->roleTable= $sm->get('Admin\Gateway\RoleTable');
    }
    return $this->roleTable;
  }
  public function getResourceTable() {
    if (!$this->resourceTable) {
      $sm = $this->getServiceLocator();
      $this->resourceTable= $sm->get('Admin\Gateway\ResourceTable');
    }
    return $this->resourceTable;
  }


  public function init() {
      $this->acl    = new AccessControlList();
      
      $sm             = $this->getServiceLocator();
      $roleTable      = $this->getRoleTable($sm);
      $resourceTable  = $this->getResourceTable($sm);

      $roles = $roleTable->getRoles(); 
      foreach($roles as $role)
        $this->acl->addRole(new Role($role['title']));
        
      $resources = $resourceTable->getResources();
      foreach($resources as $resource)
        if (!$this->acl->hasResource($resource['namespace']))
          $this->acl->addResource(new Resource($resource['namespace']));

      foreach($roles as $role) {
        $roleResources = $resourceTable->getResourcesByRole($role['role_id']);

        foreach($roleResources as $resource)
          $this->acl->allow($role['title'], $resource['namespace']);
      }
  }

  public function check($routeMatch) {
      $roleTable      = $this->getRoleTable();
      $resourceTable  = $this->getResourceTable();

      $authedEmployee = $this->getServiceLocator()->get('AuthedEmployeeService');
      $employee       = $authedEmployee->getEmployee();
      
      $userRoles      = $roleTable->getRolesByEmployeeID($employee->getEmployeeID());
      $roles          = array_filter($roleTable->getRoles(),function($role) {
        return $role['is_active'];
      });

      $routeName      = $routeMatch->getMatchedRouteName();


      $matches = array();
      preg_match_all("/[a-zA-Z]+|\*/", $routeName, $matches);
      ErrorLog::log(array_map(function($match) {
        return ($match == "*") ? $match : $match;
      }, $matches));
      ErrorLog::log($routeName);

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

}
