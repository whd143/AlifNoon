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
        $this->setAttribute('id', "validate-demo-js");
        $this->setAttribute('class', 'form-horizontal themed');
        
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
                'class' => 'with-search',
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
                'maxlength' => 64,
                'class' => 'form-control',
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
                'maxlength' => 64,
                'class' => 'form-control',
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
                'class' => 'form-control',
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
                'class' => 'form-control',
            ),
            'options' => array(
                 'label' => 'Password',
             ),
        )); 
 
        $this->add(array( 
            'name' => 'is_active', 
            'type' => 'Zend\Form\Element\Checkbox', 
            'attributes' => array(                
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
                'maxlength' => 64,
                'class' => 'form-control',
            ), 
            'options' => array(
                 'label' => 'Dashboard',
             ),
        ));
        
        
        $this->add(array( 
            'name' => 'is_driver', 
            'type' => 'Zend\Form\Element\Checkbox', 
            'attributes' => array(               
            ),
            'options' => array(
                 'label' => 'Driver?',
             ),
        )); 
        
        $this->add(array( 
            'name' => 'roles', 
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'attributes' => array(                 
                'class' => 'employee_roles',
            ),
            'options' => array(
                 'label' => 'Roles',                 
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
