 <?php

function display_flashes(){
if($_SESSION['flash']['notice_alert']): 			
			   echo '
<span class="notice">
';				 
				    echo $_SESSION['flash']['notice_alert'];  				 
				 echo '
</span>
';			
			endif;
				
			if($_SESSION['flash']['warning_alert']):			
			   echo '
<span class="warning">
';				 
echo $_SESSION['flash']['warning_alert'];				 
				 echo '
</span>
';			
			endif;
}




//Alert functions
/**
 * creates warning msg used for errors.
 * @param string $msg
 * @return bool
 */
function flash_warning($msg)
{
    if (!$msg) {
        return false;
    }
    $_SESSION['flash']['warning_alert'] = $msg;
    return true;
}

function flash_strict_warning($msg)
{
    if (!$msg) {
        return false;
    }
    $_SESSION['flash']['warning_alert'] = "<b class=\"alert\">!</b> " . $msg;;
    return true;
}

/**
 * creates notice msg used for success
 * @param string $msg
 * @return bool
 */
function flash_notice($msg)
{
    if (!$msg) {
        return false;
    }
    $_SESSION['flash']['notice_alert'] = $msg;
    return true;
}

function flash_strict_notice($msg)
{
    if (!$msg) {
        return false;
    }
    $_SESSION['flash']['notice_alert'] = "<b class=\"alert\">!</b> " . $msg;
    return true;
}


function reset_flashes(){
    
     $_SESSION['flash']['warning_alert'] = '';
     $_SESSION['flash']['notice_alert'] = '';
}


/**
*Render functions
*/

/**
*Allows different controller views to be shared amongst controllers
*Takes the controller path function and view
*renders out to the controller path view
* pulled from epsu and needs to be worked on.
*
**/

function renderTo($controller,$view=null,$params = null){
	
	if($params){
		$_SESSION['params'] = $params;
	}
 
    if(file_exists('layouts'.DS.'default.php')){
        require_once('layouts'.DS.'default.php');
    }else{
        require_once('layouts'.DS.'layout.php');
    }
	
}


