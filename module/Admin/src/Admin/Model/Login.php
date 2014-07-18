<?php 

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class Login extends AbstractTableGateway
{

  protected $userSessionTable;

  public function getUserSessionTable() {
    if (!$this->userSessionTable) {
      $sm = $this->getServiceLocator();
      $this->userSessionTable = $sm->get('Admin\Model\UserSessionTable');
    }
    return $this->userSessionTable;
  }

  public static function authenticate($user,$password) {
    if (!$user) return false;
    return ($user->getPassword() == $password) ? true : false;
  }

  public static function genToken() {
    return $_SESSION['token'] = md5(uniqid(rand(), true));
  }
  
  public function saveToken($user, $token) {
    $this->getUserSessionTable()->saveToken($user, $token);
    return $token; 
  }



}
