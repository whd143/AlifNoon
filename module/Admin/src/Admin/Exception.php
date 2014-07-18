<?php namespace Admin;

class Exception extends \Exception {

  private $status;
  private $data;

  protected static $severity = "error";

  public function __construct($message = NULL, $data = array()) {
    if (!is_null($message)) {
      parent::__construct($message);
    }
    //$data['severity'] = static::$severity;
    $this->setData($data);

    if (!$this->getStatus()) 
      $this->setStatus(\Zend\Http\Response::STATUS_CODE_500);

    //\Admin\Helper\ErrorLog::log(debug_backtrace());
    \Admin\Helper\ErrorLog::log(parent::getFile());
    \Admin\Helper\ErrorLog::log(parent::getLine());
    \Admin\Helper\ErrorLog::log(parent::getMessage());
    //\Admin\Helper\ErrorLog::log(parent::__toString());
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($status) {
    $this->status = $status;
  }

  public function getSeverity() {
    $data = $this->getData();
    return $data['severity'];
  }

  public function getData() {
    return $this->data;
  }

  public function setData($data) {
    $this->data = $data;
  }

}
