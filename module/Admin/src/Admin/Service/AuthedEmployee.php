<?php
namespace Admin\Service;

use \Zend\ServiceManager\ServiceLocatorAwareInterface;
use \Zend\ServiceManager\ServiceLocatorInterface;

class AuthedEmployee implements ServiceLocatorAwareInterface {

  protected $serviceLocator;

  protected $employee; 
  protected $employeeTable;
  protected $employeeSessionTable;

  public function setServiceLocator(ServiceLocatorInterface $sl) {
    $this->serviceLocator = $sl;
  }

  public function getServiceLocator() {
    return $this->serviceLocator;
  }
  
  public function getEmployeeTable() {
    if (!$this->employeeTable) {
      $sm = $this->getServiceLocator();
      $this->employeeTable = $sm->get('Admin\Gateway\EmployeeTable');
    }
    return $this->employeeTable;
  }
  
  public function getEmployeeSessionTable() {
    if (!$this->employeeSessionTable) {
      $sm = $this->getServiceLocator();
      $this->employeeSessionTable = $sm->get('Admin\Gateway\EmployeeSessionTable');
    }
    return $this->employeeSessionTable;
  }


  public function init() {
    $request = $this->getServiceLocator()->get('Request');
    $headers          = $request->getHeaders();

    if ($headers->has('Authorization')) { 
      $token            = $headers->get('Authorization')->getFieldValue();
      $employeeSession  = $this->getEmployeeSessionTable()->getEmployeeByToken($token);
      $this->employee   = $this->getEmployeeTable()->getEmployee($employeeSession->getEmployeeID());
    }

  }

  public function getEmployee() {
    return $this->employee;
  }


}
