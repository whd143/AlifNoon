<?php

namespace Authentication\Form;

use Zend\Form\Form;

class RenewPasswordForm extends Form {

    public function __construct($name = null) {

        parent::__construct('RenewPwd');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-signin');
        $this->setAttribute('novalidate', true);
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'required' => 'required',
                'class' => 'input-block-level',
                'placeholder' => 'Password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'confirm_password',
            'attributes' => array(
                'type' => 'password',
                'required' => 'required',
                'class' => 'input-block-level',
                'placeholder' => 'Password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'class' => 'btn btn-primary'
            ),
        ));
    }

}
