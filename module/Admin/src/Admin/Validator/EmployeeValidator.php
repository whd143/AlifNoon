<?php
namespace Admin\Validator; 

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 

class EmployeeValidator implements InputFilterAwareInterface 
{ 
    protected $inputFilter; 
    
    public function setInputFilter(InputFilterInterface $inputFilter) 
    { 
        throw new \Exception("Not used"); 
    } 
    
    public function getInputFilter() 
    { 
      if (!$this->inputFilter) 
      { 
        $inputFilter = new InputFilter(); 
        $factory = new InputFactory(); 
            
        $inputFilter->add($factory->createInput([ 
            'name' => 'employee_id', 
            'required' => 0, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
            ), 
        ])); 
        
        $inputFilter->add($factory->createInput([ 
            'name' => 'department_id', 
            'required' => 1, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
              
            ), 
        ])); 
 
        $inputFilter->add($factory->createInput([ 
            'name' => 'first_name', 
            'required' => 1, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
              array(
                'name' => 'Alpha'
              )
            ), 
        ])); 
 
        $inputFilter->add($factory->createInput([ 
            'name' => 'last_name', 
            'required' => 1, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
              array(
                'name' => 'Alpha'
              )
            ), 
        ])); 
 
        $inputFilter->add($factory->createInput([ 
            'name' => 'email', 
            'required' => 1, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
                array ( 
                    'name' => 'EmailAddress', 
                    'options' => array( 
                        'messages' => array( 
                            'emailAddressInvalidFormat' => 'Email address format is not invalid', 
                        ) 
                    ), 
                ), 
                array ( 
                    'name' => 'NotEmpty', 
                    'options' => array( 
                        'messages' => array( 
                            'isEmpty' => 'Email address is required', 
                        ) 
                    ), 
                ), 
            ), 
        ])); 
 
        $inputFilter->add($factory->createInput([ 
            'name' => 'password', 
            'required' => 1, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
              array(
                'name' => 'StringLength',
                'options' => array(
                  'min' => 6
                )
              )
                 
            ), 
        ])); 
 
        /*$inputFilter->add($factory->createInput([ 
            'name' => 'is_active', 
            'required' => 1, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
            ), 
            ]));*/
        
        $inputFilter->add($factory->createInput([ 
            'name' => 'dashboard', 
            'required' => 1, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
            ), 
        ])); 
        
        /*$inputFilter->add($factory->createInput([ 
            'name' => 'is_driver', 
            'required' => 1, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
            ), 
            ]));*/
        
        
        
        
        
        
        
        $this->inputFilter = $inputFilter; 
      } 
        
     return $this->inputFilter; 
  } 
} 
