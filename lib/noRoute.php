<?php

global $ALERTS;
global $STP_HTML;

 if(file_exists(strtolower(CONTROLLER_PATH.$_SERVER['DEFAULT_CONTROLLER']).'.Controller.php')){
     if(require_once strtolower(CONTROLLER_PATH.$_SERVER['DEFAULT_CONTROLLER']).'.Controller.php'){
       $controller = ucfirst($_SERVER['DEFAULT_CONTROLLER']);
        $aztrasController = new  $controller;
        if(method_exists($aztrasController,$view)){
            $aztrasController->$view();
        }else{
		
            include (LIB_PATH . 'layout' . DS . 'header.php');

            if (file_exists(LIB_PATH . 'layout' . DS . 'default.php')) {
                require (LIB_PATH . 'layout' . DS . 'default.php');

            } else {
                if (require_once (LIB_PATH . 'layout' . DS . 'layout.php')) {

                    require LIB_PATH . 'layout' . DS . '444.php';
                }
            }
            include (LIB_PATH . 'layout' . DS . 'footer.php');
        }
        
     }else{
        exit("<h1>Oops! Could not load controller ($_SERVER[DEFAULT_CONTROLLER]).</h1>
    Please contact the system administrator or program vendor!
    ");
     }
     
 }
 else{
    exit("<h1>Oops! The controller ($_SERVER[DEFAULT_CONTROLLER]) does not exist</h1>
    Please contact the system administrator or program vendor!
    ");
   }
