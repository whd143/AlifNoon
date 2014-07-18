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

use Admin\Model\Department;
use Admin\Form\DepartmentForm;
use Admin\Validator\DepartmentValidator;


class DepartmentController extends AbstractActionController
{

  protected $departmentTable;
  protected $roleTable;
  
  public function getDepartmentTable() {
    if (!$this->departmentTable) {
      $sm = $this->getServiceLocator();
      $this->departmentTable = $sm->get('Admin\Gateway\DepartmentTable');
    }
    return $this->departmentTable;
  }
  
  public function getRoleTable() {
    if (!$this->roleTable) {
      $sm = $this->getServiceLocator();
      $this->roleTable = $sm->get('Admin\Gateway\RoleTable');
    }
    return $this->roleTable;
  }

  public function indexAction() {
      return new ViewModel(array( 
        "departments" => $this->getDepartmentTable()->getDepartments() 
      ));
    /*return new JsonModel(array( 
      "departments" => $this->getDepartmentTable()->getDepartments() 
    ));*/
  }
  
  public function viewAction() {
    $department_id = $this->params()->fromRoute('department_id');
    return new JsonModel(array( 
      "department" => $this->getDepartmentTable()->getDepartment($department_id)
    ));
  }
  
  
  public function updateAction() {
    $department_id = $this->params()->fromRoute('department_id');
    
    
    
    
    
    
    
         if (!$department_id) {
             return $this->redirect()->toRoute('admin/department', array(
                 'action' => 'add'
             ));
         }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $department = $this->getDepartmentTable()->getDepartment($department_id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('admin/department', array(
                 'action' => 'index'
             ));
         }
         $form  = new DepartmentForm();
         //echo '<pre>'; print_r($department); echo '<pre>'; die('here');
         $form->bind($department);
         
         $form->get('submit')->setAttribute('value', 'Edit');
         

         $request = $this->getRequest();
         if ($request->isPost()) {
             
             //$department           = new Department();
             
             $departmentValidator  = new DepartmentValidator();
             $form->setInputFilter($departmentValidator->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 
                 $this->getDepartmentTable()->save($department);                 

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('admin/department');
             }
         }
         
         return new ViewModel(array( 
            'department_id' => $department_id,
            'form' => $form,
             'errors' => $form->getMessages()
          ));
         
         
         
         
         
         
    
    
    
    
    
    
    
    /*return new ViewModel(array( 
      "department" => $this->getDepartmentTable()->getDepartment($department_id)
    ));*/
    /*return new JsonModel(array( 
      "department" => $this->getDepartmentTable()->getDepartment($department_id)
    ));*/
  }

  public function rolesAction() {
    $department_id = $this->params()->fromRoute('department_id');
    return new JsonModel(array(
      "roles" => $this->getRoleTable()->getRolesByDepartmentID($department_id)
    ));
  }

  public function addAction() {

    $form = new DepartmentForm();

    if ($this->getRequest()->isPost()) {

      $department           = new Department();
      $departmentValidator  = new DepartmentValidator();

      $form->setInputFilter($departmentValidator->getInputFilter());
      $form->setData($this->getRequest()->getPost());
 
      if ($form->isValid()) {

        $department->exchangeArray($form->getData());
        $this->getDepartmentTable()->save($department);

        
        return $this->redirect()->toRoute('admin/department');
        /*return new ViewModel(array(
          "success" => $department
        ));*/
        /*return new JsonModel(array(
          "success" => $department
        ));*/
      }
      else 
      {
        return new ViewModel(array(
          'form' => $form,  
          'errors' => $form->getMessages()
        ));  
        /*return new JsonModel(array(
          'errors' => $form->getMessages()
        ));*/
      }
    } else {
       return new ViewModel(array(
         'form' => $form,  
         'errors' => 'Please use the correct method'
       ));   
      /*return new JsonModel(array(
        'errors' => 'Please use the correct method'
      ));*/
    }

  }
}
