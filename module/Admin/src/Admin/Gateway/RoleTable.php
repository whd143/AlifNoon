<?php
namespace Admin\Gateway;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;

class RoleTable extends AbstractTableGateway
{
  protected $tableGateway;
  protected $testTable;

  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }

  public function getRoles() {
    $rowset = $this->tableGateway->select();
    return array_map(function($row) {
      return $row;
    }, $rowset->toArray());
  }

  public function getRole($id) {
    $rowset   = $this->tableGateway->select(array(
      'role_id' => $id,
      //'is_active' => 1
    ));
    $row      = $rowset->current();
    if(!$row)
      throw new \Admin\Exception( "Could not find role id: $id");
    return $row;
  }

  /**
   * get employees roles as array 
   * 
   * @param int $employee_id an employees id number
   * @return array returns an array of roles
   */

  public function getRolesByEmployeeID($employee_id) {
    $select = new Select();
    $select->from('role')
      ->join( 'employee_role', 'employee_role.role_id = role.role_id')
      ->where( array('employee_role.employee_id' => $employee_id));

    return array_map(function($row) {
      return $row;
    }, $this->tableGateway->selectWith($select)->toArray());
  }

  public function addEmployeeRoles($employee_id, $employeeRoles)
  {
    $employeeRoleTable = new TableGateway(
      'employee_role', 
      $this->tableGateway->getAdapter()
    );

    foreach($employeeRoles as $employeeRole)
      $employeeRoleTable->insert(array(
        'employee_id'   => $employee_id,
        'role_id'       => $employeeRole
      ));
  }
  
  public function deleteEmployeeRoles($employee_id)
  {
    $employeeRoleTable = new TableGateway(
      'employee_role', 
      $this->tableGateway->getAdapter()
    );

    $employeeRoles = $employeeRoleTable->select(array('employee_id' => $employee_id));

    foreach($employeeRoles as $employeeRole) {
      $employeeRoleTable->delete(array(
        'employee_id' => $employeeRole['employee_id'],
        'role_id'     => $employeeRole['role_id']
      ));
    }
  }


  public function deleteRole($role_id) {
    if ($role = $this->getRole($role_id))
      $this->tableGateway->delete(array(
        'role_id' => $role->getRoleID()
      ));
  }

  public function save(\Admin\Model\Role $new_role)
  {
    $id = (int)$new_role->role_id;

    if ($id == 0) 
    {
      $d = new \DateTime();
      $new_role->date_created       = $d->format("Y-m-d H:i:s");
      $new_role->date_modified      = $d->format("Y-m-d H:i:s");

      $this->tableGateway->insert($new_role->toArray());
  
      return $this->tableGateway->getLastInsertValue();
   
    } else {

      if ($role = $this->getRole($id)) {
        $d = new \DateTime();
        $role->setDateCreated($role->getDateCreated());
        $role->setDateModified($d->format("Y-m-d H:i:s"));

        $this->tableGateway->update($new_role->toArray(), array('role_id' => $id));

      } else {
        throw new \Admin\Exception('role id does not exist');
      }
    }
  }
}
