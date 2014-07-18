<?php

namespace Admin\Model;

//http://programmers.stackexchange.com/questions/130686/is-there-a-design-pattern-that-would-apply-to-discount-models
//http://www.developerfusion.com/article/84897/dynamic-price-control-with-decorator/

class PromoDecorator {
  
  public $stackable;
  public $type;
  
  private $originalOrder;
  private $order;

  public function __contruct(Order $order)
  {
    $this->originalOrder = $this->order = $order;
  }

  public function validate()
  {
    // example
    foreach ($this->order->getItems() as $item)
      if ($item->getType() == 'whatever')
        return true;
    return false;

    if ($item->getQuantity() > 100)
      return true;
    return false;

  }

  public function apply()
  {
    if ($this->validate()) {
      $quantity = $this->order->getQuantity();
      switch ($quantity) {
      case ($quantity > 100 && $quantity < 200):
        $this->order->setPrice('6.75');
        break;
      case ($quantity > 200 && $quantity < 300):
        $this->order->setPrice('5.75');
        break;

      }
    }
    
  }




}
