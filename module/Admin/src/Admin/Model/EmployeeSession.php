<?php

namespace Admin\Model;

class EmployeeSession {

  public $employee_id;
  public $token;
  public $expiration;

  public function exchangeArray($data) {
    $this->employee_id    = ($data['employee_id'])    ? $data['employee_id']    : NULL;
    $this->token          = ($data['token'])          ? $data['token']          : NULL;
    $this->expiration     = ($data['expiration'])     ? $data['expiration']     : NULL;
  }

  public function getEmployeeID() { return $this->employee_id; }
  public function setEmployeeID($employee) { $this->employee_id = $employee; }

  public function generateToken() { return bin2hex(openssl_random_pseudo_bytes(16)); }

  public function getToken() { return $this->token; }
  public function setToken($token) { $this->token = $token; }

  public function getExpiration() { return $this->expiration; }
  public function setExpiration($expiration) { $this->expiration = $expiration; }

  public function toArray() {
    return array(
      'employee_id' => $this->employee_id,
      'token'       => $this->token,
      'expiration'  => $this->expiration
    );
  } 
}
