<?php

class Session
{
    public $logged_in = false;
    public $user_id;
    public $user_status;
    public $username;
    public $sex;
    public $fullname;
    public $email;
    public $authentication_level;
    public $device_id;

    function __construct($set_session_name = null)
    {        
     //   session_start();
     if(isset($set_session_name) && trim($set_session_name) != ''):
        define($set_session_name, APP);
     endif;
      $this->check_login();
    }

    public function is_logged_in()
    {
       if(isset($this->user_id)){
        return true;
       }
    }

    public function check_login()
    {
        if (isset($_SESSION[APP]['user']['user_id'])) {  
            $this->user_id = $_SESSION[APP]['user']['user_id'];
            $this->username = $_SESSION[APP]['user']['username'];
            $this->email = $_SESSION[APP]['user']['email'];
            $this->sex = $_SESSION[APP]['user']['sex'];
            if(isset($this->device_id)):            
                $this->device_id = $_SESSION[APP]['user']['device_id'];
            endif;
          //  $this->fullname = $_SESSION[APP]['user']['first_name'] . " " . $_SESSION[APP]['user']['last_name'];
            $this->authentication_level = $_SESSION[APP]['user']['authentication_level']; 
            $this->logged_in = true;
            return true;            
        } elseif(isset($this->device_id)){
             $_SESSION[APP]['user']['device_id'] = $this->device_id;   
             $this->logged_in = true;
            return true;
        }        
        else {            
            $this->logged_in = false;
			unset($_SESSION[APP]['user']);
            return false;            
        }
        
    }
    
    function user_id(){
        return $_SESSION[APP]['user']['user_id'];
    }
    
    public function login($user)
    {   if($user)
   
        $_SESSION[APP]['user'] = $user;
        if($this->check_login()){
            return true;
        }else{
            return false;
        }
        
    }

    public function logout()
    {
            $this->username = '';
            $this->fullname = '';
            $this->authentication_level = '';
            $this->user_id = '';
            
           // $_SESSION[APP]['user']['user_id'] = '';
            $_SESSION[APP]['user'] = null;            
        //$_SESSION[APP]['user']['device_id'] = $this->device_id;
           $this->check_login();
            return true;
    }
}
