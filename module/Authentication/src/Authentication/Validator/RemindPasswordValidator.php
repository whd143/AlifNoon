<?php

/**
 * LoginFormValidator gateway class
 * @package tfd_global
 * @subpackage SiteOperation
 * @author Waheed Mazhar <waheed.mazhar@thefreshdiet.com>
 * @copyright   The Fresh Diet, Inc
 * @since version 1.0
 * 
 */

namespace Authentication\Validator;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class RemindPasswordValidator implements InputFilterAwareInterface {

    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();


            $inputFilter->add($factory->createInput([
                        'name' => 'email',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'EmailAddress',
                                'options' => array(
                                    'domain' => true,
                                ),
                            ),
                        ),
            ]));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

}
