<?php
namespace Auth\Model;

class Auth
{
    public $id;
    public $userName;
    public $email;
    public $password;
    
    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;        
        $this->userName = !empty($data['userName']) ? $data['userName'] : null;
        $this->email  = !empty($data['email']) ? $data['email'] : null;
        $this->password  = !empty($data['password']) ? $data['password'] : null;
    }
    
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'userName' => $this->userName,
            'email'  => $this->email,
            'password'  => $this->password,
        ];
    }
}