<?php
namespace Admin\Form; 

use Zend\Form\Element; 
use Zend\Form\Form; 

class EmployeeForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct(''); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'employee_id', 
            'type' => 'Zend\Form\Element\Hidden', 
            /*'attributes' => array( 
                'required' => 'required', 
            ),*/ 
        ));
        
        $this->add(array( 
            'name' => 'date_created', 
            'type' => 'Zend\Form\Element\Hidden', 
            /*'attributes' => array( 
                'required' => 'required', 
            ),*/ 
        ));
        $this->add(array( 
            'name' => 'date_last_visited', 
            'type' => 'Zend\Form\Element\Hidden', 
            /*'attributes' => array( 
                'required' => 'required', 
            ),*/ 
        ));
        $this->add(array( 
            'name' => 'date_modified', 
            'type' => 'Zend\Form\Element\Hidden', 
            /*'attributes' => array( 
                'required' => 'required', 
            ),*/ 
        ));
        
        
        $this->add(array( 
            'name' => 'department_id', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'required' => 'required',               
            ),
            'options' => array(
                 'label' => 'Departments',
             ),
        )); 
 
        $this->add(array( 
            'name' => 'first_name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ),
            'options' => array(
                 'label' => 'First Name',
             ),
        )); 
 
        $this->add(array( 
            'name' => 'last_name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ),
            'options' => array(
                 'label' => 'Last Name',
             ),
        )); 
 
        $this->add(array( 
            'name' => 'email', 
            'type' => 'Zend\Form\Element\Email', 
            'attributes' => array( 
                'placeholder' => 'Email Address...', 
                'required' => 'required', 
            ),
            'options' => array(
                 'label' => 'Email',
             ),
        )); 
 
        $this->add(array( 
            'name' => 'password', 
            'type' => 'Zend\Form\Element\Password', 
            'attributes' => array( 
                'required' => 'required', 
            ),
            'options' => array(
                 'label' => 'Password',
             ),
        )); 
 
        $this->add(array( 
            'name' => 'is_active', 
            'type' => 'Zend\Form\Element\Checkbox', 
            'attributes' => array( 
                'required' => 'required', 
            ),
            'options' => array(
                 'label' => 'Active?',
             ),
        )); 
        
        $this->add(array( 
            'name' => 'dashboard', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ), 
            'options' => array(
                 'label' => 'Dashboard',
             ),
        ));
        
        
        $this->add(array( 
            'name' => 'is_driver', 
            'type' => 'Zend\Form\Element\Checkbox', 
            'attributes' => array( 
                'required' => 'required', 
            ),
            'options' => array(
                 'label' => 'Driver?',
             ),
        )); 
        
        $this->add(array( 
            'name' => 'roles', 
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'attributes' => array( 
                //'required' => 'required',
                'class' => 'employee_roles',
            ),
            'options' => array(
                 'label' => 'Roles',
                 //'checked_value' => '23',
                /*'value_options' => array(
                        '0' => 'Employee',
                        '23' => 'Admin',
                        '30' => 'Client',
                ),*/
             ),
        ));
        
        $this->add(array( 
            'name' => 'submit', 
            'type' => 'Zend\Form\Element\Submit', 
            'attributes' => array( 
                'value' => 'Submit',
                'class' => 'btn btn-info',
            ),
        )); 
    } 
} 
