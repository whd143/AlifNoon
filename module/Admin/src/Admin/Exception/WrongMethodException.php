<?php 
namespace Admin\Exception;

class WrongMethodException extends \Admin\Exception {

  protected static $severity = "info";
  
  public function __construct($message = "Wrong HTTP Method Used", $data = array()) {
    parent::setStatus(\Zend\Http\Response::STATUS_CODE_405);
    parent::__construct($message, $data);
  }

}
