<?php 

namespace Admin\Model;

class User {
  
  public $user_id;
  public $user_name;
  public $first_name;
  public $last_name;
  public $email;
  public $password;
  public $type;
  public $state;
  public $status;

  public function __construct() {
  }

  public function exchangeArray($data) {
    $this->user_id      = ($data['user_id'])    ? $data['user_id']    : NULL; 
    $this->user_name    = ($data['user_name'])  ? $data['user_name']  : NULL; 
    $this->first_name   = ($data['first_name']) ? $data['first_name'] : NULL; 
    $this->last_name    = ($data['last_name'])  ? $data['last_name']  : NULL;
    $this->email        = ($data['email'])      ? $data['email']      : NULL;
    $this->password     = ($data['password'])   ? $data['password']   : NULL; 
    $this->type         = ($data['type'])       ? $data['type']       : NULL;
    $this->state        = ($data['state'])      ? $data['state']      : NULL;
    $this->status       = ($data['status'])     ? $data['status']     : NULL;
  }

  public function getUserID() {
    return $this->user_id;
  }

  public function getPassword() { 
    return $this->password; 
  }

  public function toArray() {
    return array(
      'user_id'     => $this->user_id,
      'user_name'   => $this->user_name,
      'first_name'  => $this->first_name,
      'last_name'   => $this->last_name,
      'email'       => $this->email,
      'password'    => $this->password,
      'type'        => $this->type,
      'state'       => $this->state,
      'status'      => $this->status
    );

  }

}
