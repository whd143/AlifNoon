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

class RenewPasswordValidator implements InputFilterAwareInterface {

    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput([
                        'name' => 'password',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 64,
                                ),
                            ),
                        ),
            ]));

            $inputFilter->add($factory->createInput([
                        'name' => 'confirm_password',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'Identical',
                                'options' => array(
                                    'token' => 'password', /* name of first password field */
                                    'messages' => array(
                                        \Zend\Validator\Identical::NOT_SAME => 'Passwords did not match',
                                    /* \Zend\Validator\Identical::MISSING_TOKEN=>'Passwords did not match',    */
                                    ),
                                ),
                            ),
                        ),
            ]));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

}
