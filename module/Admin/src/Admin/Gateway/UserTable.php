<?php
namespace Admin\Gateway;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class UserTable extends AbstractTableGateway
{
    protected $tableGateway;
    protected $testTable;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select();;
    }

    public function getUser($id) {
      $rowset   = $this->tableGateway->select( array( 'user_id' => $id ) );
      $row      = $rowset->current();
      if(!$row)
        throw new \Admin\Exception( "Could not find user id: $id");
      return $row;
    }

    public function getUserByUsername($username) {
      $rowset   = $this->tableGateway->select(array('user_name'=>$username));
      $row      = $rowset->current();
      if (!$row)
        throw new \Admin\Exception("username: $username does not exist!");
      return $row;
    }

    public function save(User $user)
    {
      $data = $user->toArray();
      $id = (int)$data->user_id;
      if ($id == 0) {
        $this->tableGateway->insert($data);
        return $this->lastInsertValue;
      } else {
          if ($this->getUser($id)) {
              $this->update($data, array('user_id' => $id));
          } else {
              throw new \Admin\Exception('user id does not exist');
          }
      }
    }
}
