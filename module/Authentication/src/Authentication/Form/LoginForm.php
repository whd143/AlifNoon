<?php

namespace Authentication\Form;

use Zend\Form\Form;

class LoginForm extends Form {

    public function __construct($name = null) {

        parent::__construct('Login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-signin');
        $this->setAttribute('novalidate', true);
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'required' => 'required',
                'class' => 'input-block-level',
                'placeholder' => 'Email',
                'autofocus' => true
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));

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
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'class'=>'btn btn-primary'
            ),
        ));
    }

}
