<?php
namespace Admin\Gateway;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class OrderTable extends AbstractTableGateway
{
    protected $tableGateway;
    protected $testTable;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select();;
    }

    public function getOrder($id) {
      $rowset   = $this->tableGateway->select( array( 'order_id' => $id ) );
      $row      = $rowset->current();
      if(!$row)
        throw new \Exception( "Could not find order id: $id");
      return $row;
    }

    public function getOrders($start_date,$end_date) {
        $select   = new \Zend\Db\Sql\Select();
        $select
          ->from('orders')
          ->where
          ->greaterThanOrEqualTo('order_date', "$start_date 00:00:00")
          ->and
          ->lessThanOrEqualTo('order_date', "$end_date 23:59:59");
        return $this->tableGateway->selectWith($select);
    } 

    public function saveAnswer(Answer $answer)
    {
        $data = array(
            'title'         => $answer->title,
            'answer'        => $answer->answer,
            'correct'       => $answer->correct
        );

        $id = (int)$answer->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAnswer($id)) {
                $this->update($data, array('answer_id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
}
