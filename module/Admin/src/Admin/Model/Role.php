<?php
namespace Admin\Model;

class Role {
  public $role_id;
  public $title;
  public $description;
  public $parent_id;
  public $is_active;
  public $date_created;
  public $date_modified;

  public function exchangeArray($data) {
    $this->role_id        = (!is_null($data['role_id'])) ? $data['role_id'] : 0;
    $this->title          = (!is_null($data['title'])) ? $data['title'] : NULL;
    $this->description    = (!is_null($data['description'])) ? $data['description'] : NULL;
    $this->parent_id      = (!is_null($data['parent_id'])) ? $data['parent_id'] : NULL;
    $this->is_active      = (!is_null($data['is_active'])) ? $data['is_active'] : 0;
    $this->date_created   = (!is_null($data['date_created'])) ? $data['date_created'] : NULL;
    $this->date_modified  = (!is_null($data['date_modified'])) ? $data['date_modified'] : NULL;
  }
       
  public function getRoleID() {
    return $this->role_id;
  }
  public function setRoleID($role_id) {
    $this->role_id = $role_id;
  }
  public function getTitle() {
    return $this->title;
  }
  public function setTitle($title) {
    $this->title = $title;
  }
  public function getDescription() {
    return $this->description;
  }
  public function setDescription($description) {
    $this->description = $description;
  }
  public function getParentID() {
    return $this->parent_id;
  }
  public function setParentID($parent_id) {
    $this->parent_id = $parent_id;
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
      'role_id'         => $this->getRoleID(), 
      'title'           => $this->getTitle(), 
      'description'     => $this->getDescription(), 
      'parent_id'       => $this->getParentID(), 
      'is_active'       => $this->getIsActive(), 
      'date_created'    => $this->getDateCreated(), 
      'date_modified'   => $this->getDateModified(), 
    );
  }



}
?>
