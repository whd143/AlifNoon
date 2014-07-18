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

class IndexController extends AbstractActionController
{

  protected $orderTable;
  public function getOrderTable() {
    if (!$this->orderTable) {
      $sm = $this->getServiceLocator();
      $this->orderTable = $sm->get('Admin\Gateway\OrderTable');
    }
    return $this->orderTable;
  }

    public function indexAction()
    {
       // \Zend\Debug\Debug::dump($this->getOrderTable()->getOrder(123));
        return new JsonModel(array(
          'AdminModule'
        ));
    }
}
