<?php
namespace Admin\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form; 

class DepartmentForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct(''); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'department_id', 
            'type' => 'Zend\Form\Element\Hidden', 
            /*'attributes' => array( 
                'required' => 'required', 
            ),*/ 
        )); 
        $this->add(array( 
            'name' => 'title', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ),
            'options' => array(
                 'label' => 'Title',
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
            'name' => 'date_created', 
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
            'name' => 'submit', 
            'type' => 'Zend\Form\Element\Submit', 
            'attributes' => array( 
                'value' => 'Submit',
                'class' => 'btn btn-info',
            ),
        ));
 
    } 
} 
