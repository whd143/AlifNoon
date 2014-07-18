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
use Zend\View\Model\JsonModel;

use Admin\Model\Role;
use Admin\Form\RoleForm;
use Admin\Validator\RoleValidator;


class RoleController extends AbstractActionController
{

  protected $roleTable;
  protected $resourceTable;

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

  public function indexAction()
  {
    return new JsonModel(array( 
      "roles" => $this->getRoleTable()->getRoles() 
    ));
  }
  
  public function viewAction() {
    $role_id = $this->params()->fromRoute('role_id');
    return new JsonModel(array( 
      "role"        => $this->getRoleTable()->getRole($role_id),
      "resources"   => $this->getResourceTable()->getResourcesByRole($role_id)
    ));
  }










  public function resourcesAction() {
    $role_id = $this->params()->fromRoute('role_id');
    return new JsonModel(array(
      'resources' => $this->getResourceTable()->getRoleResources($role_id) 
    ));
  }













  public function deleteAction() {
    $role_id = $this->params('role_id');

    $this->getResourceTable()->deleteRoleResources($role_id);
    $this->getRoleTable()->deleteRole($role_id);

    return new JsonModel(array(
      'message' => 'Role deleted'
    ));
  }













  public function addAction() {

    $form = new RoleForm();

    if ($this->getRequest()->isPost()) {
      $post       = json_decode($this->getRequest()->getContent());
      $role       = (array)$post->role;
      $resources  = (array)$post->resources;


      $roleModel      = new Role();
      $roleValidator  = new RoleValidator();

      $form->setInputFilter($roleValidator->getInputFilter());
      $form->setData($role);

      if ($form->isValid()) {

        $roleModel->exchangeArray($form->getData());

        if ($roleModel->getRoleID() > 0) {
          $role_id = $roleModel->getRoleID();
          $this->getRoleTable()->save($roleModel);
        } else {
          $role_id = $this->getRoleTable()->save($roleModel);
        }


        $this->getResourceTable()->deleteRoleResources($role_id);
        $this->getResourceTable()->addRoleResources($role_id, $resources);

        return new JsonModel(array(
          "message" => "Role Saved."
        ));
      }
      else 
      {
        throw new \Admin\Exception\InvalidArgumentException(
          "Invalid Arguments", 
          $form->getMessages()
        );
      }
    } else {
      throw new \Admin\Exception\WrongMethodException();
    }

  }
}
