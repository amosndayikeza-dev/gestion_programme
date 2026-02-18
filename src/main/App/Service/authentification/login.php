<?php
class Login {
    private $user;
    private $password;
    public function __construct($user, $password) {
        $this->user = $user;
        $this->password = $password;
    }
    
    public function login() {
        
    }
    
    public function logout() {
        
    }
    
    public function isLogged() {
        
    }
    
    public function getUser() {
        return $this->user;
    }
    
    public function getPassword() {
        return $this->password;
    }
}
?>