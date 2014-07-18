<?php
namespace Admin\Validator; 

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 

class ResourceValidator implements InputFilterAwareInterface 
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
            'name' => 'resource_id', 
            'required' => 0, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
            ), 
        ])); 
        
        $inputFilter->add($factory->createInput([ 
            'name' => 'name', 
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
            'name' => 'namespace', 
            'required' => 1, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
            ), 
        ])); 
 
        $inputFilter->add($factory->createInput([ 
            'name' => 'is_active', 
            'required' => 0, 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
            ), 
        ])); 
 
        
        
        
        
        
        $this->inputFilter = $inputFilter; 
      } 
        
     return $this->inputFilter; 
  } 
} 
