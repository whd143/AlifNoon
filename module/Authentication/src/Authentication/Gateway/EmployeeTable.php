<?php

/**
 * EmployeeTable gateway class
 * @package tfd_global
 * @subpackage Authentication
 * @author Waheed Mazhar <waheed.mazhar@thefreshdiet.com>
 * @copyright   The Fresh Diet, Inc
 * @since version 1.0
 * 
 */

namespace Authentication\Gateway;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Authentication\Model\Employee;
use Zend\Db\Sql\Select;

class EmployeeTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getAllRecords() {
        $resultSet = $this->tableGateway->select();
        $result = array();
        foreach ($resultSet as $row) {
            $result[] = $row;
        }
        return $result;
    }

    public function getRecord($id = 0, $response_type = null) {
        $id = (int) $id;

        $rowset = $this->tableGateway->select(array('employee_id' => $id));
        $row = $rowset->current();

        if (!$row) {
            return false;
        }
        return $row;
    }

    public function saveRecord(Employee $employee) {
        if ($employee->employee_id == 0) {
            $this->tableGateway->insert($employee->getArrayCopy());
            return $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getRecord($employee->employee_id)) {
                $this->tableGateway->update($employee->getArrayCopy(), array('employee_id' => $employee->employee_id));
                return $employee->employee_id;
            } else {
                throw new \Exception('Employee record does not exist');
            }
        }
    }

    public function getRecordByEmail($email = '') {

        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();

        if (!$row) {
            return false;
        }
        return $row;
    }

    public function getRecordByRecoveryToken($password_recovery_token = '') {

        $rowset = $this->tableGateway->select(array('password_recovery_token' => $password_recovery_token));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }

}
