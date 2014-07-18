<?php 
namespace Admin\Exception;

class InvalidCredentialsException extends \Admin\Exception {

  protected static $severity = "info";
  
  public function __construct($message = "Wrong Username or Password", $data = array()) {
    parent::setStatus(\Zend\Http\Response::STATUS_CODE_403);
    parent::__construct($message, $data);
  }

}
