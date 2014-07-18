<?php
namespace Admin\Gateway;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;

class EmployeeTable extends AbstractTableGateway
{
  protected $tableGateway;
  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }

  /**
   * Get all employees 
   *
   * @return Employee returns an Employee object
   */

  public function getEmployees() {
    $rowset = $this->tableGateway->select();
    return array_map(function($row) {
      return $row;
    }, $rowset->toArray());
  }

  /**
   * Find an employee using their id number
   *
   * @param int $employee_number a unique employee number
   * @return Employee returns an Employee object
   */

  public function getEmployee($id) {
    $rowset   = $this->tableGateway->select( array( 'employee_id' => $id ) );
    $row      = $rowset->current();
    if(!$row)
      throw new \Admin\Exception( "Could not find employee id: $id");
    return $row;
  }


  public function deleteEmployee($employee_id) {
    if($employee = $this->getEmployee($employee_id))
      $this->tableGateway->delete(array('employee_id' => $employee_id));
  }

  /**
   * Find an employee using their email address
   * 
   * @param string $email an email address
   * @return Employee returns an employee object;
   */

  public function getEmployeeByEmail($email) {
    $rowset   = $this->tableGateway->select(array( 'email' => $email ));
    $row      = $rowset->current();
    if (!$row)
      throw new \Admin\Exception("email: $email does not exist!");
    return $row;
  }

  public function emailExists($email) {
    $rowset   = $this->tableGateway->select(array( 'email' => $email ));
    $row      = $rowset->current();
    if (!$row)
      return false;
    return true;
  }

  public function updatePassword(\Admin\Model\Employee $employee, $password) {
    $this->tableGateway->update(
      array('password' => $password), 
      array('employee_id' => $employee->getEmployeeID())
    );
  }


  /**
   * Persists an Employee object using a table gateway 
   * 
   * @param Employee $new_employee an Employee object 
   *
   * @throws Admin\Exception if employee has a employee_id 
   * and cannot be found to update
   * 
   * @return Employee returns an employee object if inserted
   */

  public function save(\Admin\Model\Employee $new_employee)
  {
    $id = (int)$new_employee->employee_id;
    if ($id == 0) 
    {
      // set date fields to now
      $d = new \DateTime();
      $new_employee->date_created       = $d->format("Y-m-d H:i:s");
      $new_employee->date_modified      = $d->format("Y-m-d H:i:s");
      $new_employee->date_last_visited  = $d->format("Y-m-d H:i:s");

      if($this->emailExists($new_employee->getEmail()))
        throw new \Admin\Exception("email already exists");

      $this->tableGateway->insert($new_employee->toArray());
         
      return $this->lastInsertValue;
   
    } else {

      if ($employee = $this->getEmployee($id)) {

        $d = new \DateTime();
        $new_employee->setDateCreated($employee->getDateCreated());
        $new_employee->setDateModified($d->format("Y-m-d H:i:s"));

        $this->tableGateway->update($new_employee->toArray(), array('employee_id' => $id));

      }
    }
  }
}
