<?php
namespace Admin\Gateway;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class EmployeeSessionTable extends AbstractTableGateway
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select();
    }

    public function getEmployeeSession($employee_id) {
        $rowset   = $this->tableGateway->select(array('employee_id' => $employee_id));
        $row      = $rowset->current();
        if(!$row)
            throw new \Admin\Exception( "Could not find employee id: $id");
        return $row;
    }

    public function getEmployeeByToken($token) {
      $rowset = $this->tableGateway->select(array('token'=>$token));
      $row    = $rowset->current();
      if (!$row)
        throw new \Admin\Exception\TokenException();

      $expiration = new \DateTime($row->getExpiration());
      $now        = new \DateTime();
      if ($now > $expiration) {
        $this->tableGateway->delete(array('employee_id' => $row->getEmployeeID()));
        throw new \Admin\Exception\ExpiredTokenException();
      }


      return $row;
    }

    public function clearEmployeeSessions($employee_id) {
      $this->tableGateway->delete(array('employee_id'=>$employee_id));
    }

    public function saveEmployeeSession(\Admin\Model\EmployeeSession $employee_session)
    {
      $data = $employee_session->toArray();
      $this->clearEmployeeSessions($data['employee_id']);
      $this->tableGateway->insert($data);
    }
}
