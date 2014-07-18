<?php
namespace Admin\Service;

use \Zend\ServiceManager\ServiceLocatorAwareInterface;
use \Zend\ServiceManager\ServiceLocatorInterface;

class SystemEmail implements ServiceLocatorAwareInterface {

  protected $serviceLocator;

  public function setServiceLocator(ServiceLocatorInterface $sl) {


    $this->serviceLocator = $sl;
  }

  public function getServiceLocator() {
    return $this->serviceLocator;
  }

  public function sendPasswordRecoveryEmail(\Admin\Model\Employee $employee) 
  {
    $config = $this->getServiceLocator()->get('Config');
    $from = $config['system']['email'];
    $mail   = new \Zend\Mail\Message();
    $mail->setBody('this is an automated email recovery system. your password is ' . $employee->getPassword());
    $mail->setFrom($from);
    $mail->addTo($employee->getEmail());
    $mail->setSubject('password recovery');

    $transport = new \Zend\Mail\Transport\Sendmail();
    $transport->send($mail);
  }

}
