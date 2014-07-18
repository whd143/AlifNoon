<?php
namespace Admin\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form; 

class ResourceForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct(''); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'resource_id', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'namespace', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'is_active', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                //'required' => 'required', 
            ), 
        )); 
 
    } 
} 
