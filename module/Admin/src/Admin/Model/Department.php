<?php

namespace Admin\Model;

class Department {

  public $department_id;
  public $title;
  public $is_active;
  public $date_created;
  public $date_modified;

  public function exchangeArray($data) {
    $this->department_id = ($data['department_id'] != NULL) ? $data['department_id'] : NULL;
    $this->title = ($data['title'] != NULL) ? $data['title'] : NULL;
    $this->is_active = ($data['is_active'] != NULL) ? $data['is_active'] : NULL;
    $this->date_created = ($data['date_created'] != NULL) ? $data['date_created'] : NULL;
    $this->date_modified = ($data['date_modified'] != NULL) ? $data['date_modified'] : NULL;
  }
       
  public function getDepartmentID() {
    return $this->department_id;
  }
  public function setDepartmentID($department_id) {
    $this->department_id = $department_id;
  }
  public function getTitle() {
    return $this->title;
  }
  public function setTitle($title) {
    $this->title = $title;
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


  public function toArray() {
    return array(
      'department_id' => $this->getDepartmentID(), 
      'title' => $this->getTitle(), 
      'is_active' => $this->getIsActive(), 
      'date_created' => $this->getDateCreated(), 
      'date_modified' => $this->getDateModified(), 
    );
  }
  
  public function getArrayCopy() {
    return get_object_vars($this);
  }



}
?>
