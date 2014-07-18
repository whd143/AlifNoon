<?php

namespace Admin\Model;

class Resource {
  public $resource_id;
  public $name;
  public $namespace;
  public $is_active;
  public $date_created;
  public $date_modified;

  public function exchangeArray($data) {
    $this->resource_id = ($data['resource_id'] != NULL) ? $data['resource_id'] : NULL;
    $this->name = ($data['name'] != NULL) ? $data['name'] : NULL;
    $this->namespace = ($data['namespace'] != NULL) ? $data['namespace'] : NULL;
    $this->is_active = ($data['is_active'] != NULL) ? $data['is_active'] : 0;
    $this->date_created = ($data['date_created'] != NULL) ? $data['date_created'] : NULL;
    $this->date_modified = ($data['date_modified'] != NULL) ? $data['date_modified'] : NULL;
  }
       
  public function getResourceID() {
    return $this->resource_id;
  }
  public function setResourceID($resource_id) {
    $this->resource_id = $resource_id;
  }
  public function getName() {
    return $this->name;
  }
  public function setName($name) {
    $this->name = $name;
  }

  public function getNamespace() {
    return $this->namespace;
  }
  public function setNamespace($namespace) {
    $this->namespace = $namespace;
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
      'resource_id' => $this->getResourceID(), 
      'name'      => $this->getName(),
      'namespace' => $this->getNamespace(), 
      'is_active' => $this->getIsActive(), 
      'date_created' => $this->getDateCreated(), 
      'date_modified' => $this->getDateModified(), 
    );
  }



}
?>
