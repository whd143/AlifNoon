<?php 
namespace Admin\Exception;

class NotAuthorizedException extends \Admin\Exception {

  protected static $severity = "info";
  
  public function __construct($message = "Not Authorized", $data = array()) {
    parent::setStatus(\Zend\Http\Response::STATUS_CODE_401);
    parent::__construct($message, $data);
  }

}
