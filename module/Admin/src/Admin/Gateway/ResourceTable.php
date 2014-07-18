<?php
namespace Admin\Gateway;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;

class ResourceTable extends AbstractTableGateway
{
  protected $tableGateway;
  protected $testTable;

  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }

  public function getResources() {
    $rowset = $this->tableGateway->select();
    return array_map(function($row) {
      return $row;
    }, $rowset->toArray());
  }

  public function getResource($id) {
    $rowset   = $this->tableGateway->select( array( 'resource_id' => $id ) );
    $row      = $rowset->current();
    if(!$row)
      throw new \Admin\Exception( "Could not find resource id: $id");
    return $row;
  }

  public function getResourcesByRole($role_id) {
    $select = new Select();
    $select->from('resource')
      ->join( 'role_resource', 'role_resource.resource_id = resource.resource_id')
      ->where( array('role_resource.role_id' => $role_id));

    return $this->tableGateway->selectWith($select)->toArray();
  }

  public function deleteResource($resource_id) {
    if ($resource = $this->getResource($resource_id))
      $this->tableGateway->delete(array('resource_id' => $resource_id));
  }

  public function deleteRoleResources($role_id) {
    $roleResourcesTable = new TableGateway(
      'role_resource', 
      $this->tableGateway->getAdapter()
    );

    $resources = $roleResourcesTable->select(array('role_id' => $role_id));

    foreach($resources as $resource)
      $roleResourcesTable->delete(array(
        'role_id'     => $resource['role_id'],
        'resource_id' => $resource['resource_id']
      ));   

    
  }

  public function addRoleResources($role_id, $resources) {
    $roleResourcesTable = new TableGateway(
      'role_resource', 
      $this->tableGateway->getAdapter()
    );

    foreach($resources as $resource)
      $roleResourcesTable ->insert(array(
        'role_id'     => $role_id,
        'resource_id' => $resource
      ));


  }

  public function save(\Admin\Model\Resource $new_resource)
  {
    $id = (int)$new_resource->resource_id;

    if ($id == 0) 
    {
      // set date fields to now
      $d = new \DateTime();
      $new_resource->date_created       = $d->format("Y-m-d H:i:s");
      $new_resource->date_modified      = $d->format("Y-m-d H:i:s");
      $new_resource->date_last_visited  = $d->format("Y-m-d H:i:s");

      $this->tableGateway->insert($new_resource->toArray());

      return $this->tableGateway->getLastInsertValue();
   
    } else {

      if ($resource = $this->getResource($id)) {

        $d = new \DateTime();
        $new_resource->setDateCreated($resource->getDateCreated());
        $new_resource->setDateModified($d->format("Y-m-d H:i:s"));

        $this->tableGateway->update($new_resource->toArray(), array('resource_id' => $id));

      } else {
        throw new \Admin\Exception('resource id does not exist');
      }
    }
  }
}
