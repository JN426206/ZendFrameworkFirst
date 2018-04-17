<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Zend\Uri\Uri;
use User\Form\LoginForm;
use User\Model\UserTable;
use User\Model\User;
/**
 * This controller is responsible for letting the user to log in and log out.
 */
class AuthController extends AbstractActionController
{
    private $authManager;
    private $userTable;
    /**
     * Constructor.
     */
    public function __construct($userTable, $authManager)
    {
        $this->userTable = $userTable;
        $this->authManager = $authManager;
    }
    /**
     * Authenticates user given email address and password credentials.
     */
    public function loginAction()
    {
        // Check if we do not have users in database at all. If so, create
        // the 'Admin' user.
        //$this->userTable->createAdminUserIfNotExists();
        
        if($this->authManager->getIdentity()!=null) 
            return $this->redirect()->toRoute('home');
        
        // Create login form
        $form = new LoginForm();
        // Store login status.
        $isLoginError = false;
        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            // Fill in the form with POST data
            $data = $this->params()->fromPost();
            $form->setData($data);
            // Validate form
            if($form->isValid()) {
                echo "Is valid";
                // Get filtered and validated data
                $data = $form->getData();
                // Perform login attempt.
                $result = $this->authManager->login($data['userName'], $data['password']);
                // Check result.
                if ($result->getCode() == Result::SUCCESS) {
                        return $this->redirect()->toRoute('home');
                } else {
                    $isLoginError = true;
                }
            } else {
                $isLoginError = true;
            }
        }
        return new ViewModel([
            'form' => $form,
            'isLoginError' => $isLoginError
        ]);
    }
    /**
     * The "logout" action performs logout operation.
     */
    public function logoutAction()
    {
        $this->authManager->logout();
        return $this->redirect()->toRoute('login');
    }
}