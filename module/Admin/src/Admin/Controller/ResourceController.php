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

use Admin\Model\Resource;
use Admin\Form\ResourceForm;
use Admin\Validator\ResourceValidator;


class ResourceController extends AbstractActionController
{

  protected $resourceTable;
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
      "resources" => $this->getResourceTable()->getResources() 
    ));
  }
  
  public function viewAction() {
    $resource_id = $this->params()->fromRoute('resource_id');
    return new JsonModel(array( 
      "resource" => $this->getResourceTable()->getResource($resource_id)
    ));
  }

  public function deleteAction() {
    $resource_id = $this->params('resource_id');
    $this->getResourceTable()->deleteResource($resource_id);

    return new JsonModel(array(
      'message' => 'Resource deleted'
    ));
  }


  public function addAction() {

    $form = new ResourceForm();

    if ($this->getRequest()->isPost()) {

      $post = (array)json_decode($this->getRequest()->getContent());
      
      $resource           = new Resource();
      $resourceValidator  = new ResourceValidator();

      $form->setInputFilter($resourceValidator->getInputFilter());
      $form->setData($post);

      if ($form->isValid()) {

        $resource->exchangeArray($form->getData());
        $this->getResourceTable()->save($resource);

        return new JsonModel(array(
          "message" => "Resource Saved."
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
