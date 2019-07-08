<?php

//This is the first config file that runs.
// This function must be availible
function is_secure_connection(){
    $secure_connection = 0;    
    if(isset($_SERVER['HTTPS'])){        
        $secure_connection = 1;        
        if ($_SERVER["HTTPS"] == "on"){
               return $secure_connection;
            }else{
                $secure_connection = 0;
            }
        return $secure_connection;
    }
    return $secure_connection;
}



define('DS', '/');

define('UP_ONE', '../');
define('VERSION', '3.0');


define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'] . DS);

define('APP_ADMIN', 'appadmin');
define('APP', basename(dirname(dirname(__FILE__))));
define('PARENT_APP', basename(dirname(dirname(dirname(__FILE__)))));
define('APP_FOLDER', 'application');

if(is_secure_connection() == 0):
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . DS);
define('WEB_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/' . APP . DS);
elseif(is_secure_connection() == 1):
define('BASE_URL', 'https://' . $_SERVER['HTTP_HOST'] . DS);
define('WEB_URL', 'https://' . $_SERVER['SERVER_NAME'] . '/' . APP . DS);
endif;

define('LIB_PATH', 'lib' . DS);
define('ADAPTORS_PATH', LIB_PATH .'adaptors'.DS);
define('CLASSES_PATH', LIB_PATH.'classes' . DS);
define('FUNCTIONS_PATH', LIB_PATH.'functions' . DS);
define('CONTROLLER_PATH', APP_FOLDER.DS.'controllers' . DS);
define('CONFIG_PATH','config'.DS);
define('UPLOADS_PATH', WEB_URL.'public'.DS.'uploads'.DS);
define('FILE_UPLOADS_PATH', 'public'.DS.'uploads'.DS);

//MVC PATHS
define('VIEW_PATH', APP_FOLDER.DS.'views' . DS);
define('MODEL_PATH', APP_FOLDER.DS.'models' . DS);
define('APP_LIBS', APP_FOLDER.DS.'applibs'.DS);
//RECOURCES PATH
define('RESOURCES_PATH', 'resources' . DS);

//TEMLATES
define('TEMPLATES_PATH', RESOURCES_PATH.'templates' . DS);
define('VIEWS_TEMPLATE_PATH', TEMPLATES_PATH.'views'.DS);
define('MODELS_TEMPLATE_PATH', TEMPLATES_PATH.'models'.DS);
define('CONTROLLERS_TEMPLATE_PATH', TEMPLATES_PATH.'controllers'.DS);


//Facebook Stuff
define('FACEBOOK_APPID','');
define('FACEBOOK_SECRET','');


//ResourcesPath
define('CSS_PATH', WEB_URL . 'public' . DS . 'css' . DS);
define('JS_PATH', WEB_URL . 'public' . DS . 'js' . DS);
