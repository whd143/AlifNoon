<?php

namespace Authentication\Model;

class Employee {

    public $employee_id;
    public $department_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $is_active;
    public $date_created;
    public $date_modified;
    public $date_last_visited;
    public $dashboard;
    public $is_driver;
    public $password_recovery_token;

    public function exchangeArray($data) {
        $this->employee_id = ($data['employee_id'] != NULL) ? $data['employee_id'] : 0;
        $this->department_id = ($data['department_id'] != NULL) ? $data['department_id'] : NULL;
        $this->first_name = ($data['first_name'] != NULL) ? $data['first_name'] : NULL;
        $this->last_name = ($data['last_name'] != NULL) ? $data['last_name'] : NULL;
        $this->email = ($data['email'] != NULL) ? $data['email'] : NULL;
        $this->password = ($data['password'] != NULL) ? $data['password'] : NULL;
        $this->is_active = ($data['is_active'] != NULL) ? $data['is_active'] : 0;
        $this->date_created = ($data['date_created'] != NULL) ? $data['date_created'] : NULL;
        $this->date_modified = ($data['date_modified'] != NULL) ? $data['date_modified'] : NULL;
        $this->date_last_visited = ($data['date_last_visited'] != NULL) ? $data['date_last_visited'] : NULL;
        $this->dashboard = ($data['dashboard'] != NULL) ? $data['dashboard'] : NULL;
        $this->is_driver = ($data['is_driver'] != NULL) ? $data['is_driver'] : 0;
        $this->password_recovery_token = (isset($data['password_recovery_token']) && $data['password_recovery_token'] != NULL) ? $data['password_recovery_token'] : NULL;
    }

    public function setPasswordRecoveryToken($token) {
        $passwordRecoveryToken = $token;
        if (!is_null($token)) {
            //$binaryLength = 64;
            //$randomBinaryString = mcrypt_create_iv($binaryLength, MCRYPT_DEV_URANDOM);
            //$randomBase64String = base64_encode($randomBinaryString);
            //$passwordRecoveryToken = substr($randomBase64String, 0, 64);
            $passwordRecoveryToken=  md5($this->email.time());
        }

        $this->password_recovery_token = $passwordRecoveryToken;
    }

    public function setPassword($password) {
        $this->password = md5($password);
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
