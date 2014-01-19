<?php
namespace Front\Model;

class User
{
    public $idUser;
    public $email;
    public $password;
    public $isActive;
    public $type;
    public $createdAt;
    
    public function exchangeArray($data)
    {
        $this->idUser = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->isActive = (isset($data['is_active'])) ? $data['is_active'] : null;
        $this->type = (isset($data['type'])) ? $data['type'] : null;
        $this->createdAt = (isset($data['created_at'])) ? $data['created_at'] : null;
    }
}
