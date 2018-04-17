<?php
namespace User\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use User\Model\UserTable;
use User\Model\User;
/**
 * Adapter used for authenticating user. It takes login and password on input
 * and checks the database if there is a user with such login (email) and password.
 * If such user exists, the service returns its identity (email). The identity
 * is saved to session and can be retrieved later with Identity view helper provided
 * by ZF3.
 */
class AuthAdapter implements AdapterInterface
{
    private $userName;
    private $password;
    private $userTable;
    
    /**
     * Constructor.
     */
    public function __construct($userTable)
    {
        $this->userTable = $userTable;
    }
    
    /**
     * Sets user email.
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
    
    /**
     * Sets password.
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }
    
    /**
     * Performs an authentication attempt.
     */
    public function authenticate()
    {
        // Check the database if there is a user with such email.
        $userRow = $this->userTable->findOneByEmail($this->userName);
        $user = new User();
        $user->exchangeArray($userRow);
       
        
        // If there is no such user, return 'Identity Not Found' status.
        if ($user == null) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials.']);
        }
        
        // Now we need to calculate hash based on user-entered password and compare
        // it with the password hash stored in database.
        $passwordHash = $user->password;
        
        if ($user->password == $this->password) {
            // Great! The password hash matches. Return user identity (email) to be
            // saved in session for later use.
            return new Result(
                Result::SUCCESS,
                $this->userName,
                ['Authenticated successfully.']);
        }
        
        // If password check didn't pass return 'Invalid Credential' failure status.
        return new Result(
            Result::FAILURE_CREDENTIAL_INVALID,
            null,
            ['Invalid credentials.']);
    }
}
