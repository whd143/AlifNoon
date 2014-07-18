<?php
namespace Admin\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class AuthService implements ServiceLocatorAwareInterface 
{
  use ServiceLocatorAwareTrait;

  public function setServiceLocator(ServiceLocatorInterface $sl) {
    $this->services = $sl;
  }

  public function getServiceLocator()
  {
    return $this->services;
  }


  public function __construct() {
  }

  public function isAuthenticated() {


  }

  public function destroy() 
  {


  }

  public function getUser()
  {

    \Admin\Helper\ErrorLog::log($this->services);
  }

}
