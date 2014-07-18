<?php

namespace Admin\Model;

class Task {

  public $task_id;
  public $title;
  public $description;
  public $priority;
  public $status;
  public $category;

  public $client_id;

  public $created_by;
  public $assigned_by;
  public $assigned_to;
  public $completed_by;

  public $date_due;
  public $date_created;
  public $date_started;
  public $date_completed;

  public $deleted;

  public function exchangeArray($data) {
    $this->order_id       = (isset($data['order_id']))        ? $data['order_id']         : NULL;
    $this->client_id      = (isset($data['client_id']))       ? $data['client_id']        : NULL;

    $this->task_id        = (isset($data['task_id']))         ? $data['task_id']          : NULL;
    $this->title          = (isset($data['title']))           ? $data['title']            : NULL;
    $this->description    = (isset($data['description']))     ? $data['description']      : NULL;
    $this->priority       = (isset($data['priority']))        ? $data['priority']         : NULL;
    $this->status         = (isset($data['status']))          ? $data['status']           : NULL;
    $this->category       = (isset($data['category']))        ? $data['category']         : NULL;

    $this->client_id      = (isset($data['client_id']))       ? $data['client_id']        : NULL;

    $this->created_by     = (isset($data['created_by']))      ? $data['created_by']       : NULL;
    $this->assigned_by    = (isset($data['assigned_by']))     ? $data['assigned_by']      : NULL;
    $this->assigned_to    = (isset($data['assigned_to']))     ? $data['assigned_to']      : NULL;
    $this->completed_by   = (isset($data['completed_by']))    ? $data['completed_by']     : NULL;

    $this->date_due       = (isset($data['date_due']))        ? $data['date_due']         : NULL;
    $this->date_created   = (isset($data['date_created']))    ? $data['date_created']     : NULL;
    $this->date_started   = (isset($data['date_started']))    ? $data['date_started']     : NULL;
    $this->date_completed = (isset($data['date_completed']))  ? $data['date_completed']   : NULL;

    $this->deleted        = (isset($data['deleted']))         ? $data['deleted']          : NULL;
  }

  public function getID() { return $this->order_id; }
  public function setID($order_id) { $this->order_id = $order_id; }

  // move this to parent class
  function toArray() {
    return array(
      'order_id'    => $this->getID(),
      'client_id'   => $this->getID(),
      'task_id'     => $this->getTaskID(),
      'title'       => $this->getTitle()
    );
  }

}
