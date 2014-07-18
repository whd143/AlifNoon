<?php
namespace Admin\Gateway;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;

class DepartmentTable extends AbstractTableGateway
{
  protected $tableGateway;
  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }

  /**
   * Get all Departments 
   *
   * @return Department returns an Department object
   */

  public function getDepartments() {
    $rowset = $this->tableGateway->select();
    return array_map(function($row) {
      return $row;
    }, $rowset->toArray());
  }

  /**
   * Find an department using their id number
   *
   * @param int $department_number a unique department number
   * @return Department returns an Department object
   */

  public function getDepartment($id) {
    $rowset   = $this->tableGateway->select( array( 'department_id' => $id ) );
    $row      = $rowset->current();
    if(!$row)
      throw new \Admin\Exception( "Could not find department id: $id");
    return $row;
  }

  /**
   * Find an department using their email address
   * 
   * @param string $email an email address
   * @return Department returns an department object;
   */

  public function getDepartmentByEmail($email) {
    $rowset   = $this->tableGateway->select(array( 'email' => $email ));
    $row      = $rowset->current();
    if (!$row)
      throw new \Admin\Exception("email: $email does not exist!");
    return $row;
  }

  /**
   * Persists an Department object using a table gateway 
   * 
   * @param Department $new_department an Department object 
   *
   * @throws Admin\Exception if department has a department_id 
   * and cannot be found to update
   * 
   * @return Department returns an department object if inserted
   */

  public function save(\Admin\Model\Department $new_department)
  {
    $id = (int)$new_department->department_id;

    if ($id == 0) 
    {
      // set date fields to now
      $d = new \DateTime();
      $new_department->date_created       = $d->format("Y-m-d H:i:s");
      $new_department->date_modified      = $d->format("Y-m-d H:i:s");
      $new_department->date_last_visited  = $d->format("Y-m-d H:i:s");

      $this->tableGateway->insert($new_department->toArray());
  
      return $this->lastInsertValue;
   
    } else {

      if ($department = $this->getDepartment($id)) {

        $d = new \DateTime();
        $new_department->setDateCreated($department->getDateCreated());
        $new_department->setDateModified($d->format("Y-m-d H:i:s"));

        $this->tableGateway->update($new_department->toArray(), array('department_id' => $id));

      }
    }
  }
}
