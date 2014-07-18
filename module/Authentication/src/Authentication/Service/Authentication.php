<?php

// Set the namespace

namespace Authentication\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
// We give this one an alias, because otherwise 
// DbTable might confuse us in thinking that it is 
// an actual db table
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\Storage\Session;

// We want to make a service, so we implement the 
// ServiceLocatorAwareInterface for that as well
class Authentication implements ServiceLocatorAwareInterface {

// Storage for our service locator
    private $servicelocator;

// Get the ServiceManager
    public function getServiceLocator() {
        return $this->servicelocator;
    }

// Set the ServiceManager
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $this->servicelocator = $serviceLocator;
    }

    /**
     * Lets us know if we are authenticated or not.
     * 
     * @return boolean
     */
    public function isAuthenticated() {
// Check if the authentication session is empty, if 
// not we assume we are authenticated
        $session = new Session();
// Return false if the session IS empty, and true if 
// the session ISN'T empty
        return !$session->isEmpty();
    }

    /**
     * Authenticates the user against the Authentication 
     * adapter.
     * 
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function authenticate($username, $password) {
// Create our authentication adapter, and set our 
// DbAdapter (the one we created before) by getting
        // it from the ServiceManager. Also tell the adapter 
// to use table 'users', where 'username' is the 
// identity and 'password' is the credential column
//        $authentication = new AuthDbTable(
//                $this->getServiceLocator()->get('db'), 'users', 'username', 'password'
//        );

        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $authentication = new DbTableAuthAdapter($dbAdapter, 'employee', 'email', 'password', 'MD5(?)');

// We use md5 in here because SQLite doesn't have 
// any functionality to encrypt strings

        $result = $authentication->setIdentity($username)
                ->setCredential($password)
                ->authenticate();

// Check if we are successfully authenticated or not
        if ($result->isValid() === true) {
// Now save the identity to the session
            $session = new Session();
            $session->write($result->getIdentity());

            /**
             * 
             */
            $sessionEmployoeeInfo = new \Zend\Session\Container('employee_info');
            $employeeTable = $this->getServiceLocator()->get('EmployeeTable');
            $record = $employeeTable->getRecordByEmail($result->getIdentity());
            $sessionEmployoeeInfo->name = $record->first_name." ".$record->last_name;
        }
        return $result->isValid();
    }

    /**
     * Gets the identity of the user, if available, 
     * otherwise returns false.
     * @return array
     */
    public function getIdentity() {
// Clear out the session, we are done here
        $session = new Session();
// Check if the session is empty, if not return the 
// identity of the logged in user
        if ($session->isEmpty() === false) {
            return $session->read();
        } else {
            return false;
        }
    }

    /**
     * Logs the user out by clearing the session.
     */
    public function logout() {
// Clear out the session, we are done here
        $session = new Session();
        $session->clear();
    }

}
