<?php

namespace Admin\Model;

class Order {

  public $order_id;
  public $user_id;

  public function exchangeArray($data) {
    $this->order_id         = (isset($data['order_id']))        ? $data['order_id']         : NULL;
    $this->user_id          = (isset($data['user_id']))         ? $data['user_id']          : NULL;
    $this->salesperson_id   = (isset($data['salesperson_id']))  ? $data['salesperson_id']   : NULL;
    $this->order_date       = (isset($data['order_date']))      ? $data['order_date']       : NULL;
    $this->status           = (isset($data['status']))          ? $data['status']           : NULL;
    $this->start_date       = (isset($data['start_date']))      ? $data['start_date']       : NULL;
    $this->type             = (isset($data['type']))            ? $data['type']             : NULL;
    $this->class            = (isset($data['class']))           ? $data['class']            : NULL;
    $this->sale_type        = (isset($data['sale_type']))       ? $data['sale_type']        : NULL;
    $this->subtotal         = (isset($data['subtotal']))        ? $data['subtotal']         : NULL;
    $this->tax_rate         = (isset($data['tax_rate']))        ? $data['tax_rate']         : NULL;
    $this->taxtotal         = (isset($data['taxtotal']))        ? $data['taxtotal']         : NULL;
    $this->total            = (isset($data['total']))           ? $data['total']            : NULL;
    $this->type    = (isset($data['type'])) ? $data['type'] : NULL;
    $this->type    = (isset($data['type'])) ? $data['type'] : NULL;
    $this->type    = (isset($data['type'])) ? $data['type'] : NULL;
    $this->type    = (isset($data['type'])) ? $data['type'] : NULL;
    $this->type    = (isset($data['type'])) ? $data['type'] : NULL;
  }

  public function getID() { return $this->order_id; }
  public function setID($order_id) { $this->order_id = $order_id; }

  public function getUserID() { return $this->user_id; }
  public function setUserID() { $this->user_id = $user_id; }

  public function getSalesPersonID() { return $this->salesperson_id; }
  public function getOrderDate() { return $this->order_date; }
  public function getStatus() { return $this->status; }
  public function getStartDate() { return $this->start_date; }
  public function getType() { return $this->type; }
  public function getClass() { return $this->class; }
  public function getSaleType() { return $this->sale_type; }
  public function getSubTotal() { return $this->subtotal; }
  public function getTaxRaTe() { return $this->tax_rate; }
  public function getTotal() { return $this->total; }


  public function validate() {
    foreach ($this->getItems() as $item)
      $item->validate();
  }

  public function refund(Refund $refund) {

  }

  // move this to parent class
  function toArray() {
    return array(
      'order_id'        => $this->getID(),
      'user_id'       => $this->getUserID(),
      'salesperson_id'  => $this->getSalesPersonID(),
      'order_date'      => $this->getOrderDate(),
      'status'          => $this->getStatus(),
      'start_date'      => $this->getStartDate(),
      'type'            => $this->getType(),
      'class'           => $this->getClass(),
      'sale_type'       => $this->getSaleType(),
      'subtotal'        => $this->getSubTotal(),
      'tax_rate'        => $this->getTaxRaTe(),
      'total'           => $this->getTotal()
    );
  }

}
