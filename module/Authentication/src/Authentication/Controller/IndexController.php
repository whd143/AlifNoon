<?php

/**
 * IndexController gateway class
 * @package tfd_global
 * @subpackage SiteOperation
 * @author Waheed Mazhar <waheed.mazhar@thefreshdiet.com>
 * @copyright   The Fresh Diet, Inc
 * @since version 1.0
 * 
 */

namespace Authentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

//use Authentication\Gateway\EmployeeTable;
class IndexController extends AbstractActionController {

    public function indexAction() {

        $form = new \Authentication\Form\LoginForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $loginValidator = new \Authentication\Validator\LoginValidator();
            $form->setInputFilter($loginValidator->getInputFilter());
            $form->setData($request->getPost());

            /**
             * Validate the logon credential
             */
            if ($form->isValid()) {
                $formData = $form->getData();

                /**
                 * Try to authenticate the user posted data 
                 */
                $status = $this->getServiceLocator()->get('AuthService')->authenticate($formData['email'], $formData['password']);
                if ($status) {
                    $this->redirect()->toRoute('admin/dashboard');
                } else {
                    return new ViewModel(array('form' => $form, 'error' => true));
                }
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function remindpasswordAction() {
        $form = new \Authentication\Form\RemindPasswordForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $formValidator = new \Authentication\Validator\RemindPasswordValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $employeeTable = $this->getServiceLocator()->get('EmployeeTable');
                $formData = $form->getData();
                $record = $employeeTable->getRecordByEmail($formData['email']);

                if ($record) {


                    $employeeModel = new \Authentication\Model\Employee();
                    $employeeModel->exchangeArray((array) $record);
                    $employeeModel->setPasswordRecoveryToken(true);
                    $employeeTable->saveRecord($employeeModel);

                    $config = $this->getServiceLocator()->get('config');
                    if ($config instanceof Traversable) {
                        $config = ArrayUtils::iteratorToArray($config);
                    }

                    /* base url */
                    $helper = $this->getServiceLocator()->get('ViewHelperManager')->get('ServerUrl');
                    $baseUrl = $helper->__invoke('');


                    $mail = new \Zend\Mail\Message();
                    $mail->setFrom($config['tfd_config']['email']['sender_email'], $config['tfd_config']['email']['sender_title']);
                    $mail->addTo($record->email, $record->first_name . ' ' . $record->last_name);
                    $mail->setSubject('Your thefreshdiet.com renew password instructions!');
                    $mailBody = '<table style="font-family:Arial,sans-serif;background:#fafafa" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>

                                                    <div style="max-width:670px;margin:0 auto;padding:5% 0">

                                                        <table style="border:1px solid #cccccc;background:#ffffff" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:10px 30px 15px 42px" valign="top">
                                                                        <b style="color:#4f5f6f;font-size:20px;font-family:Tahoma,sans-serif">Dear Sir/Madam,</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:3px 30px 10px 42px" valign="top">
                                                                        <span style="color:#4f5f6f;font-size:13px">
                                                                            You have requested to change your TFD account password. To finish this process, please visit the following link:
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:10px 30px 20px 42px" valign="top">
                                                                        <a href="' . $baseUrl . $this->url()->fromRoute('admin/renewPassword', array('token' => $employeeModel->password_recovery_token), array()) . '" style="color:#0574b5;text-decoration:none;display:block;word-wrap:break-word;word-break:break-all;font-size:10px" target="_blank">
                                                                            ' . $baseUrl . $this->url()->fromRoute('admin/renewPassword', array('token' => $employeeModel->password_recovery_token), array()) . '
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:3px 30px 10px 42px" valign="top">
                                                                        <span style="color:#4f5f6f;font-size:13px">
                                                                            If you didn\'t request any changes, just ignore this message.  or
                                                                            contact our support team at <a href="mailto:' . $config['tfd_config']['email']['sender_email'] . '" style="color:#0574b5;text-decoration:none" target="_blank">support@thefreshdiet.com</a>.
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:0 30px 20px 42px" valign="top">
                                                                        <br><i style="color:#8a8a8a;font-size:13px">' . $config['tfd_config']['email']['sender_title'] . '</i>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:0 30px 0 42px" valign="top">
                                                                        <table style="border-top:1px dotted #e1e2e3" cellpadding="0" cellspacing="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding:15px 0">
                                                                                        <span style="color:#8a8a8a;font-size:11px">
                                                                                            This is an automated e-mail message, please do not reply directly. You can contact us by sending an e-mail to <a href="mailto:support@thefreshdiet.com" style="color:#0574b5;text-decoration:none" target="_blank">support@thefreshdiet.com</a>.
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding-top:10px;border-top:1px #dfdfdf solid">
                                                                        <span style="color:#7a7a7a;font-size:11px;font-family:Tahoma,sans-serif">&copy;2014 thefreshdiet. ALL RIGHTS RESERVED.</span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';

                    /**                     * * */
                    $mimeMessage = new \Zend\Mime\Message();
                    $mimePart = new \Zend\Mime\Part($mailBody);
                    $mimePart->type = 'text/html';
                    $mimeMessage->setParts(array($mimePart));
                    /*                     * ** */
                    $mail->setEncoding('UTF-8');
                    $mail->setBody($mimeMessage);
                    $transport = new \Zend\Mail\Transport\Sendmail();
                    $transport->send($mail);
                    $viewModel = new ViewModel();
                    $viewModel->setTemplate('authentication/index/remind_notification');
                    return $viewModel;
                } else {
                    return new ViewModel(array('form' => $form, 'error' => true));
                }
            } else {
                return new ViewModel(array('form' => $form, 'error' => true));
            }
        } else {
            return new ViewModel(array('form' => $form));
        }
    }

    public function renewpasswordAction() {

        $form = new \Authentication\Form\RenewPasswordForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $formValidator = new \Authentication\Validator\RenewPasswordValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $session = new \Zend\Session\Container('recovery_token');
                $employeeTable = $this->getServiceLocator()->get('EmployeeTable');
                $record = $employeeTable->getRecord($session->employee_id);
                $employeeModel = new \Authentication\Model\Employee();

                $employeeModel->exchangeArray((array) $record);
                $employeeModel->setPasswordRecoveryToken(null);
                $employeeModel->setPassword($form->getData()['password']);
                $employeeTable->saveRecord($employeeModel);
                $session->getManager()->getStorage()->clear('recovery_token');
                $viewModel = new ViewModel();
                $viewModel->setTemplate('authentication/index/passwordrenewed');
                return $viewModel;
            } else {
                return new ViewModel(array('form' => $form));
            }
        } else {
            $passwordRecoveryToken = trim($this->params()->fromRoute('token'));
            $employeeTable = $this->getServiceLocator()->get('EmployeeTable');
            $record = $employeeTable->getRecordByRecoveryToken($passwordRecoveryToken);
            if ($record) {
                $session = new \Zend\Session\Container('recovery_token');
                $session->employee_id = $record->employee_id;
                return new ViewModel(array('form' => $form));
            } else {
                $viewModel = new ViewModel();
                $viewModel->setTemplate('authentication/index/invalidtoken');
                return $viewModel;
            }
        }
    }

    public function logoutAction() {
        /**
         *  Log out the user
         */
        $this->getServiceLocator()->get('AuthService')->logout();
        /**
         *  Redirect the user back to the login screen
         */
        $this->redirect()->toRoute('admin');
    }

}
