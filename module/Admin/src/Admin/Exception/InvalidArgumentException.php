<?php 
namespace Admin\Exception;

class InvalidArgumentException extends \Admin\Exception {

  protected static $severity = "info";
  
  public function __construct($message = "Invalid Arguments", $data = array()) {
    parent::setStatus(\Zend\Http\Response::STATUS_CODE_422);


    if (! empty($data)) {
      $dataClone  = $data;
      $data       = array();  
      foreach($dataClone as $key => $value) {
        foreach($value as $error)
          $data[] = "$key: $error";
      }

      error_log(var_export($data,true));
    }
    
    
    parent::__construct($message, $data);
  }

}
