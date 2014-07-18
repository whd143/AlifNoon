<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AuthController extends AbstractActionController
{

  protected $employeeTable;
  protected $employeeSessionTable;

  protected $roleTable;
  protected $resourceTable;

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


  public function getRoleTable() {
    if (!$this->roleTable) {
      $sm = $this->getServiceLocator();
      $this->roleTable = $sm->get('Admin\Gateway\RoleTable');
    }
    return $this->roleTable;
  }

  public function getResourceTable() {
    if (!$this->resourceTable) {
      $sm = $this->getServiceLocator();
      $this->resourceTable = $sm->get('Admin\Gateway\ResourceTable');
    }
    return $this->resourceTable;
  }




  public function checkAction()
  {
    $request          = $this->getRequest();
    $headers          = $request->getHeaders();
    if ($headers->has('Authorization')) {
      $token            = $headers->get('Authorization')->getFieldValue();
      $employeeSession  = $this->getEmployeeSessionTable()->getEmployeeByToken($token);
      $employee         = $this->getEmployeeTable()->getEmployee($employeeSession->getEmployeeID());

      $resources = array_map(function($role) {
        $resources = $this->getResourceTable()->getResourcesByRole($role['role_id']);
        return iterator_to_array(new \RecursiveIteratorIterator(
          new \RecursiveArrayIterator($resources)), false);
      }, $this->getRoleTable()->getRolesByEmployeeID($employee->getEmployeeID()));

      return new JsonModel(array(
        'employee' => $employee,
        'resource' => $resources 
      ));
    }
  }



  public function indexAction()
  {

    if ($this->getRequest()->isPost()) {
      $post = json_decode($this->getRequest()->getContent());

      $username     = $post->username;
      $password     = $post->password;

      if ( empty($username) || empty($password) )
        throw new \Admin\Exception\InvalidCredentialsException();

      $employee   = $this->getEmployeeTable()->getEmployeeByEmail($username);

      if ($employee->getPassword() != $password)
        throw new \Admin\Exception('username and password do not match');


      $expiration = new \DateTime();
      $expiration->modify("+1 day");

      $employee_session = new \Admin\Model\EmployeeSession();
      $employee_session->setEmployeeID($employee->getEmployeeID());
      $employee_session->setToken($employee_session->generateToken());
      $employee_session->setExpiration($expiration->format("Y-m-d h:m:s"));

      $this->getEmployeeSessionTable()->saveEmployeeSession($employee_session);

      
      return new JsonModel(array(
        'token'     => $employee_session->getToken()
      ));

    } else {
      throw new \Admin\Exception\WrongMethodException();
    }
  }

  public function destroyAction()
  {
    if ($this->getRequest()->isPost())
    {
      $request          = $this->getRequest();
      $headers          = $request->getHeaders();
      $token            = $headers->get('Authorization')->getFieldValue();
      $this->getEmployeeSessionTable()->delete(array('token'=>$token));
       

    } else
      throw new \Admin\Exception\WrongMethodException();

  }



  public function recoverAction()
  {
    if ($this->getRequest()->isPost()) {
      $post     = json_decode($this->getRequest()->getContent());
      $username = $post->username;
  
      try {
        $employee = $this->getEmployeeTable()->getEmployeeByEmail($username);
      } catch (\Admin\Exception $e) {
        throw new \Admin\Exception('if you have an account in our system an has been sent with your password');
      }

      $systemEmail = $this->getServiceLocator()->get('SystemEmailService');
      $systemEmail->sendPasswordRecoveryEmail($employee);

      return new JsonModel(array(
        'message' => 'if you have an account in our system an email has been sent with your password.'
      ));

    } else 
      throw new \Admin\Exception\WrongMethodException();
  }






  /*


  public function registerAction()
  {
    $username   = $this->params()->fromQuery('username');
    $password   = $this->params()->fromQuery('password');
    $password1  = $this->params()->fromQuery('password1');
    $zip        = $this->params()->fromQuery('zip');

    $user       = $this->getUserTable()->getUserByUsername($username);

    if ($user)
      throw new \Admin\Exception("User already exists");

    if ($password != $password1)
      throw new \Admin\Exception("passwords do not match");

    if ($zip == "")
      throw new \Admin\Exception("no zip");

    $u            = new \Admin\Model\User();
    $u->user_name = $username;
    $u->password  = $password;

    $this->getUserTable()->save($u);

    return JsonModel(array(
      'user_id' => $u->user_id
    ));

  }





  public function loginAction()
  {
    $username   = $this->params()->fromQuery('username');
    $password   = $this->params()->fromQuery('password');

    $user       = $this->getUserTable()->getUserByUsername($username) ;
    $login      = new \Admin\Model\Login();

    if ($user->getPassword() == $password) {

      $expiration = new \DateTime();
      $expiration->modify("+1 day");

      $user_session = new \Admin\Model\UserSession();
      $user_session->setUserID($user->getUserID());
      $user_session->setToken($user_session->generateToken());
      $user_session->setExpiration($expiration->format("Y-m-d h:m:s"));
      
      $this->getUserSessionTable()->saveUserSession($user_session);
      
      $token = $user_session->getToken();
    }      
    
    return new JsonModel(array(
      'username'  => $username,
      'token'     => $token
    ));
  }

   */
}
