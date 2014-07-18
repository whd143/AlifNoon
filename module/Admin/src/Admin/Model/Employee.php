<?php
namespace Admin\Model;

class Employee {
  public $employee_id;
  public $department_id;
  public $first_name;
  public $last_name;
  public $email;
  public $password;
  public $is_active;
  public $date_created;
  public $date_modified;
  public $date_last_visited;
  public $dashboard;
  public $is_driver;

  public function exchangeArray($data) {
    $this->employee_id = ($data['employee_id'] != NULL) ? $data['employee_id'] : 0;
    $this->department_id = ($data['department_id'] != NULL) ? $data['department_id'] : NULL;
    $this->first_name = ($data['first_name'] != NULL) ? $data['first_name'] : NULL;
    $this->last_name = ($data['last_name'] != NULL) ? $data['last_name'] : NULL;
    $this->email = ($data['email'] != NULL) ? $data['email'] : NULL;
    $this->password = ($data['password'] != NULL) ? $data['password'] : NULL;
    $this->is_active = ($data['is_active'] != NULL) ? $data['is_active'] : 0;
    $this->date_created = ($data['date_created'] != NULL) ? $data['date_created'] : NULL;
    $this->date_modified = ($data['date_modified'] != NULL) ? $data['date_modified'] : NULL;
    $this->date_last_visited = ($data['date_last_visited'] != NULL) ? $data['date_last_visited'] : NULL;
    $this->dashboard = ($data['dashboard'] != NULL) ? $data['dashboard'] : NULL;
    $this->is_driver = ($data['is_driver'] != NULL) ? $data['is_driver'] : 0;
  }
       
  public function getEmployeeID() {
    return $this->employee_id;
  }
  public function setEmployeeID($employee_id) {
    $this->employee_id = $employee_id;
  }

  public function getDepartmentID() {
    return $this->department_id;
  }
  public function setDepartmentID($department_id) {
    $this->department_id = department_id;
  }

  public function getFirstName() {
    return $this->first_name;
  }
  public function setFirstName($first_name) {
    $this->first_name = $first_name;
  }

  public function getLastName() {
    return $this->last_name;
  }
  public function setLastName($last_name) {
    $this->last_name = $last_name;
  }

  public function getEmail() {
    return $this->email;
  }
  public function setEmail($email) {
    $this->email = $email;
  }

  public function getPassword() {
    return $this->password;
  }
  public function setPassword($password) {
    $this->password = $password;
  }

  public function getIsActive() {
    return $this->is_active;
  }
  public function setIsActive($is_active) {
    $this->is_active = $is_active;
  }

  public function getDateCreated() {
    return $this->date_created;
  }
  public function setDateCreated($date_created) {
    $this->date_created = $date_created;
  }

  public function getDateModified() {
    return $this->date_modified;
  }
  public function setDateModified($date_modified) {
    $this->date_modified = $date_modified;
  }

  public function getDateLastVisited() {
    return $this->date_last_visited;
  }
  public function setDateLastVisited($date_last_visited) {
    $this->date_last_visited = $date_last_visited;
  }

  public function getDashboard() {
    return $this->dashboard;
  }
  public function setDashboard($dashboard) {
    $this->dashboard = $dashboard;
  }
  
  public function getIsDriver() {
    return $this->is_driver;
  }

  public function setIsDriver($isDriver) {
    $this->is_driver = $isDriver;
  }


  public function toArray() {
    return array(
      'employee_id'       => $this->getEmployeeID(),
      'department_id'     => $this->getDepartmentID(),
      'first_name'        => $this->getFirstName(),
      'last_name'         => $this->getLastName(),
      'email'             => $this->getEmail(),
      'password'          => $this->getPassword(),
      'is_active'         => $this->getIsActive(),
      'date_created'      => $this->getDateCreated(),
      'date_modified'     => $this->getDateModified(),
      'date_last_visited' => $this->getDateLastVisited(),
      'dashboard'         => $this->getDashboard(),
      'is_driver'         => $this->getIsDriver()    
    );
  }
  
  public function getArrayCopy() {
    return get_object_vars($this);
  }

}
?>
