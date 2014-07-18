<?php 
namespace Admin\Exception;

class TokenException extends \Admin\Exception {

  protected static $severity = "info";
  
  public function __construct($message = "Token Exception", $data = array()) {
    parent::setStatus(\Zend\Http\Response::STATUS_CODE_401);
    parent::__construct($message, $data);
  }

}
