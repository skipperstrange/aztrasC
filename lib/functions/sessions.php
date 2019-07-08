<?php
function authenticated($authentication_level){
    global $SESSION;
    if($SESSION->authentication_level >= $authentication_level){
        return true;
    }else{
        return false;
    }
}

function admin_authenticate_blocker($authentication_level,$controller = null,$view = null){
    if(!isset($controller) || trim($controller) == ''):$contoller = APP;endif;
    if(!isset($view) || trim($view) == ''):$view = 'index';endif;
    
    if(authenticated($authentication_level)){
        return true;
    }
    else{
        flash_warning("You are not to authourized perform this action or access this section! ");
        redirect_to($controller,$view);
    }
}

function login_authenticate_blocker($authentication_level,$controller = null,$view = null){
    if(!isset($controller) || trim($controller) == ''):$contoller = APP;endif;
    if(!isset($view) || trim($view) == ''):$view = 'index';endif;
    
    if(authenticated($authentication_level)){
        return true;
    }
    else{
        flash_warning("You need to be logged in first.");
        redirect_to($controller,$view);
    }
}
?>