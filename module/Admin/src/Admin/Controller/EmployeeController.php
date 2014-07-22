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

use Admin\Model\Employee;
use Admin\Form\EmployeeForm;
use Admin\Validator\EmployeeValidator;


class EmployeeController extends AbstractActionController
{

  protected $employeeTable;
  protected $employeeSessionTable;
  protected $roleTable;
  protected $departmentTable;
  
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
  
  public function getDepartmentTable() {
    if (!$this->departmentTable) {
      $sm = $this->getServiceLocator();
      $this->departmentTable = $sm->get('Admin\Gateway\DepartmentTable');
    }
    return $this->departmentTable;
  }







  public function indexAction() { 
    return new ViewModel(array( 
      "employees" => $this->getEmployeeTable()->getEmployees() 
    ));
    /*return new JsonModel(array( 
      "employees" => $this->getEmployeeTable()->getEmployees() 
    ));*/
  }





  public function viewAction() {
    $employee_id = $this->params()->fromRoute('employee_id');
    return new JsonModel(array( 
      "employee"  => $this->getEmployeeTable()->getEmployee($employee_id),
      "roles"     => $this->getRoleTable()->getRolesByEmployeeID($employee_id)
    ));
  }






  public function profileAction() {
    $authedEmployee   = $this->getServiceLocator()->get('AuthedEmployeeService');
    $employee         = $authedEmployee->getEmployee();

    return new JsonModel(array(
      'employee' => $employee
    ));

  }






  public function updateProfileAction() {
     $employee_id = (int) $this->params()->fromRoute('employee_id', 0);
     //echo $employee_id; die('here');
     
     $departments = $this->getDepartmentTable()->getDepartments();
     $dep_options = array();
     foreach($departments as $department) {
        $dep_options[$department['department_id']] = $department['title'];
     } 
     
     $roles = $this->getRoleTable()->getRoles();
     $role_options = array();
     foreach($roles as $role) {
         $role_options[$role['role_id']] = $role['title'];
     }            
     
     if (!$employee_id) {
        return $this->redirect()->toRoute('admin/employee/add', array(
            'action' => 'add'
        ));
     }
     
     
     // if it cannot be found, in which case go to the index page.
     try {
        $employee = $this->getEmployeeTable()->getEmployee($employee_id);
     }
     catch (\Exception $ex) {
        return $this->redirect()->toRoute('admin/employee', array(
            'action' => 'index'
        ));
     }
     
     
     
     
    $form = new EmployeeForm();
    //echo '<pre>'; print_r($employee); echo '<pre>'; die('here');
    $form->get('department_id')->setAttribute('options', $dep_options);
    $element = $form->get('roles');
    $element->setValueOptions($role_options);
    
    $form->bind($employee);    
    $form->get('submit')->setAttribute('value', 'Edit');

    if ($this->getRequest()->isPost()) {
        $post       = $this->getRequest()->getPost();
        
        
        //echo '<pre>'; print_r($post); echo '<pre>'; die('here');
        
        
        
        //$employee = new Employee();
        $employeeValidator  = new EmployeeValidator();
         $form->setInputFilter($employeeValidator->getInputFilter());
         $form->setData($post);

         if ($form->isValid()) {
            $this->getEmployeeTable()->save($employee);

            // Redirect to list of employees listing
            return $this->redirect()->toRoute('admin/employees');
            
         } else {
             return new ViewModel(array(
                "form" => $form,
                "employee_id" => $employee_id,
                'errors' => $form->getMessages()
              ));
             
         }
        
        
        
       /* 
      //$post       = json_decode($this->getRequest()->getContent());
//echo '<pre>'; print_r($post); echo $post['first_name']; die('here');
      $authedEmp  = $this->getServiceLocator()->get('AuthedEmployeeService');
      //echo '<pre>'; print_r($authedEmp); echo $post['first_name']; die('here');

      $employee   = $authedEmp->getEmployee();
      $employee->setFirstName($post['first_name']);
      $employee->setLastName($post['last_name']);
      $employee->setEmail($post['email']);
      /*$employee->setFirstName($post->first_name);
      $employee->setLastName($post->last_name);
      $employee->setEmail($post->email);*/

      /*$this->getEmployeeTable()->save($employee);

      return new ViewModel(array(
        "form" => $form,  
        'message' => 'your profile has been updated.'
      ));*/
      /*return new JsonModel(array(
        'message' => 'your profile has been updated.'
      ));*/
    } else  {
        return new ViewModel(array(
        "form" => $form,
        "employee_id" => $employee_id
      ));
      //throw new \Admin\Exception\WrongMethodException();
    }
  }








  public function passwordAction() 
  {

    if ($this->getRequest()->isPost()) {

      $post = json_decode($this->getRequest()->getContent());

      if ($post->password1 != $post->password2)
        throw new \Admin\Exception('passwords do not match');
      
      $request          = $this->getRequest();
      $headers          = $request->getHeaders();
      $token            = $headers->get('Authorization')->getFieldValue();
      $employeeSession  = $this->getEmployeeSessionTable()->getEmployeeByToken($token);
      $employee         = $this->getEmployeeTable()->getEmployee($employeeSession->getEmployeeID());

      if ($post->current_password != $employee->getPassword())
        throw new \Admin\Exception('your current password is incorrect.');

      $this->getEmployeeTable()->updatePassword($employee, $post->password1);
      return new JsonModel(array(
        'message' => 'Your password has been updated.'
      ));

    } else
      throw new \Admin\Exception\WrongMethodException();

  }

  public function rolesAction() {
    $employee_id = $this->params()->fromRoute('employee_id');
    return new JsonModel(array(
      "roles" => $this->getRoleTable()->getRolesByEmployeeID($employee_id)
    ));
  }

  public function deleteAction() {
    $employee_id = $this->params('employee_id');

    $this->getRoleTable()->deleteEmployeeRoles($employee_id);
    $this->getEmployeeTable()->deleteEmployee($employee_id);
    
    return new ViewModel(array(
      'message' => 'Employee deleted'
    ));

    /*return new JsonModel(array(
      'message' => 'Employee deleted'
    ));*/
  }

  public function addAction() {
    $form = new EmployeeForm();
    $departments = $this->getDepartmentTable()->getDepartments();
    $dep_options = array();
    foreach($departments as $department) {
        $dep_options[$department['department_id']] = $department['title'];
    }
    $form->get('department_id')->setAttribute('options', $dep_options);
    
    $roles = $this->getRoleTable()->getRoles();
    $role_options = array();
    foreach($roles as $role) {
        $role_options[$role['role_id']] = $role['title'];
    }       
    $element = $form->get('roles');
    $element->setValueOptions($role_options);

    if ($this->getRequest()->isPost()) {
      //$post = json_decode($this->getRequest()->getContent());
      $post = $this->getRequest()->getPost();
      //echo '<pre>';      print_r($post); echo '</pre>'; die('here');

      $employee      = $post;
      $employeeRoles = $post['roles']; 
      //echo '<pre>';      print_r($employeeRoles); echo '</pre>';

      $employeeModel      = new Employee();
      $employeeValidator  = new EmployeeValidator();

      $form->setInputFilter($employeeValidator->getInputFilter());
      $form->setData($employee);

      if ($form->isValid()) {

        $employeeModel->exchangeArray($form->getData());
        $this->getEmployeeTable()->save($employeeModel);

        // working on it
        /*$this->getRoleTable()->deleteEmployeeRoles($employeeModel->getEmployeeID());
        $this->getRoleTable()->addEmployeeRoles($employeeModel->getEmployeeID(), $employeeRoles);*/

        return new ViewModel(array(
          "form" => $form,
          "message" => "employee saved",
        ));
        /*return new JsonModel(array(
          "message" => "employee saved"
        ));*/
      }
      else 
      {
        throw new \Admin\Exception\InvalidArgumentException(
          "Invalid Arguments", 
          $form->getMessages()
        );
      }
    } else {
      //throw new \Admin\Exception\WrongMethodException();
      return new ViewModel(array(
        "form" => $form
      ));
    }


  }
}
