<?php
namespace User\Service;
use Zend\Authentication\Result;
/**
 * The AuthManager service is responsible for user's login/logout and simple access
 * filtering. The access filtering feature checks whether the current visitor
 * is allowed to see the given page or not.
 */
class AuthManager
{
    private $authService;
    private $sessionManager;
    private $config;
    
    /**
     * Constructs the service.
     */
    public function __construct($authService, $sessionManager, $config)
    {
        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
        $this->config = $config;
    }
    
    /**
     * Performs a login attempt. If $rememberMe argument is true, it forces the session
     * to last for one month (otherwise the session expires on one hour).
     */
    public function login($userName, $password)
    {
        // Check if user has already logged in. If so, do not allow to log in
        // twice.
        if ($this->authService->getIdentity()!=null) {
            throw new \Exception('Already logged in');
        }
        
        // Authenticate with login/password.
        $authAdapter = $this->authService->getAdapter();
        $authAdapter->setUserName($userName);
        $authAdapter->setPassword($password);
        $result = $this->authService->authenticate();
        // If user wants to "remember him", we will make session to expire in
        // one month. By default session expires in 1 hour (as specified in our
        // config/global.php file).
        if ($result->getCode()==Result::SUCCESS) {
            // Session cookie will expire in 1 month (30 days).
            //$this->sessionManager->rememberMe(60*60*24*30);
        }
        
        return $result;
    }
    
    public function getIdentity() {
        return $this->authService->getIdentity();
    }
    
    /**
     * Performs user logout.
     */
    public function logout()
    {
        // Allow to log out only when user is logged in.
        if ($this->authService->getIdentity()==null) {
            throw new \Exception('The user is not logged in');
        }
        
        // Remove identity from session.
        $this->authService->clearIdentity();
    }
}