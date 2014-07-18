<?php
namespace Admin\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form; 

class RoleForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct(''); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'role_id', 
            'type' => 'Zend\Form\Element\Text', 
        )); 
        
        $this->add(array( 
            'name' => 'title', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'description', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'parent_id', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'is_active', 
            'type' => 'Zend\Form\Element\Text', 
        )); 
 
    } 
} 
