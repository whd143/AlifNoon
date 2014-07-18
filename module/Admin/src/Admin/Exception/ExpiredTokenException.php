<?php 
namespace Admin\Exception;

class ExpiredTokenException extends \Admin\Exception {

  protected static $severity = "info";
  
  public function __construct($message = "Expired Token", $data = array()) {
    parent::setStatus(\Zend\Http\Response::STATUS_CODE_401);
    parent::__construct($message, $data);
  }

}
