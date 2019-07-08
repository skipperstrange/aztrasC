<?php
/*
* Aztraz/ScoopMinimal - PHP MVC Framework libraries
*
* Copyright (C) 20011 Nana Yaw Duah A.K.A Skipper Strange <skipperstrange@gmail.com>
*
* Developers:
*       Nana Yaw Duah A.K.A Skipper Strange <skipperstrange@gmail.com>
*
* Contributors:
		Philip Quanoo <pquanoo18@gmail.com>
*
*
* This program is free software; you can redistribute it and/or modify it under the terms of the
* GNU Lesser General Public License as published by the Free Software Foundation.
* Also under the publishers notice under his terms and or regulations <skipperstrange@gmail.com>
*
* Read the full licence: http://www.opensource.org/licenses/lgpl-license.php
*/


#doc
#           Main  functions file
#        scope:            PUBLIC
#
#
#/doc


@include 'route_fxns.php';

//strips all uneccessary spaces out of strings
function refactor_sent($string){
    return implode(' ',ArrayRemoveEmpty(explode(' ',trim($string))));
}


//Templates
function useViewTemplate($name, $data = null,$error_report = null)
{
    
    if(is_array($data)){
        extract($data);
    }
    if (file_exists(VIEWS_TEMPLATE_PATH . $name . '.php')) {
        global $STP_HTML;
        require (VIEWS_TEMPLATE_PATH . $name . '.php');
        return true;
    } else {
        if($error_report == true):
        echo "Template \"<style=\"color:red;\">$name.php\"</span> does not exist in the <b>view templates folder</b>";
        endif;
        return false;
    }
}

function useControllerTemplate($name, $error_report = null)
{
    if (file_exists(CONTROLLERS_TEMPLATE_PATH . $name . '.php')) {
        global $STP_HTML;
        require (CONTROLLERS_TEMPLATE_PATH . $name . '.php');
        return true;
    } else {
        if($error_report == true):
        echo "Template \"<style=\"color:red;\">$name.php\"</span> does not exist in the <b>controller templates folder</b>";
        endif;
        return false;
    }
}

function useModelTemplate($name, $error_report = null)
{
    if (file_exists(MODELS_TEMPLATE_PATH . $name . '.php')) {
        global $STP_HTML;
        require (MODELS_TEMPLATE_PATH . $name . '.php');
        return true;
    } else {
        if($error_report == true):
        echo "Template \"<style=\"color:red;\">$name.php\"</span> does not exist in the <b>model templates folder</b>";
        endif;
        return false;
    }
}


//redirects
/*
function redirect_to($controller = null, $view = null)
{
    $webAdd = 'index.php?';
    if (isset($controller) && trim($controller) != ''):
        $webAdd .= 'controller=' . $controller;
    endif;
    if ((isset($view) && trim($view) != '') && (isset($controller) && trim($controller) !=
        '')) {
        $webAdd .= '&';
    }
    if (isset($view) && trim($view) != ''):
        $webAdd .= 'view=' . $view;
    endif;

    header('location:' . rtrim(WEB_URL,'/') . '/' . $webAdd);
    exit;
}
*/
function redirect_to($controller = null, $view = null)
{

    $url = 'index.php?';
    if (isset($controller) && trim($controller) != ''):
        $url .= 'controller=' . $controller;
    endif;
    if ((isset($view) && trim($view) != '') && (isset($controller) && trim($controller) !=
        '')) {
        $url .= '&';
    }
    if (isset($view) && trim($view) != ''):
        $url .= 'view=' . $view;
    endif;
    
   
   $computed_url = $url;
    if($_SERVER['scRouteConfig'] == 'On'):   
        if (preg_match('/[?]/', $url)) {
            $computed_url = '';
                    $url = implode('~!~|',setArrayKeyEqualValue(explode('=',$url)));
                    $url = implode('!~!~',explode('&',$url));
                   // echo $url;
                    $url = explode('~!~|',$url);
                    foreach($url as $u => $h):
                        $collected = explode('!~!~',$h);
                        
                        $computed_url.= $collected[0].'/';
                    endforeach;
                  $computed_url = rtrim(str_replace('index.php?','',str_replace('view/','',str_replace('controller/','',$computed_url))), '/');
                                
            } else {
                $url;
            }

    endif;
    $url = $computed_url;
   // print_r($url);
    header('location:' .WEB_URL. $url);
    exit();
}

function admin_redirect_to($controller = null, $view = null)
{
    $webAdd = 'appadmin/index.php?';
    if (isset($controller) && trim($controller) != ''):
        $webAdd .= 'controller=' . $controller;
    endif;
    if ((isset($view) && trim($view) != '') && (isset($controller) && trim($controller) !=
        '')) {
        $webAdd .= '&';
    }
    if (isset($view) && trim($view) != ''):
        $webAdd .= 'view=' . $view;
    endif;

    header('location:' . WEB_URL . $webAdd);
    exit;
}


//Array Functions
//takes an array and removes all empty value keys
/**
 *@abstract function that removes all empty keys in an array
 *@author skipper
 *@param array
 */
function ArrayRemoveEmpty($arr)
{
    $arr = array_filter($arr);
    return $arr;
}


//takes an array and removes all empty value keys
/**
 *@abstract function that removes all empty keys in an array and returns them in order
 * keys will be replaced by indexed keys
 *@author skipper
 *@param array
 */
function ArrayRemoveEmptyOrder($arr)
{

    $arr = array_filter($arr);

    $newMy = array();
    $i = 0;

    foreach ($arr as $key => $value) {
        if (!is_null($value)) {
            $newMy[$i] = $value;
            $i++;
        }
    }
    return $newMy;
}

/** Array functions
 */

function setArrayKeyEqualValue($array)
{
    $new_array = array();
    foreach ($array as $arr => $value) {
        $new_array[$value] = $value;
    }
    return $new_array;
}


function setArrayValueEqualKey($array)
{
    $new_array = array();
    foreach ($array as $arr => $value) {
        $new_array[$arr] = $arr;
    }
    return $new_array;
}


function printArrayStructure($array)
{
    foreach ($array as $ft => $each) {
        if (is_array($array[$ft])) {
            echo "<p>+$ft <br/>
        ";
            //  getArrayValues($array[$ft]);
            echo "-$ft <br/>
        </p>
        ";
        } else {
            echo "<p>+$ft <br/>";
            echo "  " . $each . "<br/>";
            echo "-$ft <br/>
     </p>";
        }
    }
}

/*
function redirectTo($controller = null, $view = null)
{

    if (isset($controller) && trim($controller) != '') {
        $address .= 'controller=' . $controller;
    }

    if (isset($page) && trim($page) != '' && isset($controller) && trim($controller) !=
        '') {
        $address .= '&view=' . $view;
    } elseif (isset($page) && trim($page) != '') {
        $address .= '?view=' . $view;
    }

    header('Location:?' . $address);
    exit();
}
*/

//Array fxns

function filterOutArrayIndexed($array)
{
    $filtered_array = array();
    if (is_array($array)) {
        foreach ($array as $arr => $value) {
            if (!is_int($arr)) {
                $filtered_array[$arr] = $value;
            }
        }
        return $filtered_array;
    } else {
        return false;
    }

}

function filterOutArrayNonIndexed($array)
{
    $filtered_array = array();
    foreach ($array as $arr => $value) {

        if (is_int($arr)) {
            $filtered_array[$arr] = $value;
        }
    }
    return $filtered_array;
}

function loadAppIndex()
{
    global $controller;
    global $view;

    global $STP_HTML;
    global $ALERTS;

    if (file_exists(APP_FOLDER . DS . 'index.php')) {
        include APP_FOLDER . DS . 'index.php';
    } else {
        die('
<html>
<head>
<title>Could not start</title>
</head>
<body style="font:arial;font-size:80%;">
<h1>Sorry... I can\'t continue!</h1>
<div style="width:97%;margin:auto;">
<div style="border:solid 1px #ff7070;padding:3px;width:100%;background:#fcddf6;margin:5px auto;">The application <b>' .
            APP . '</b> could not load.
Pleas make sure the app index exists in the applications folder. Copy and paste the <b>app loader</b> code below into your index to load your application.</div>
<br /><div style="border:solid 1px #b7d4f7;padding:3px;width:100%;background:#ddebfc;margin:5px auto;"><b>File Location:</b>
'.
            APP_FOLDER . DS . 'index.php

<p>
<b>App Loader code:</b><br /><br />

&lt;?php
<br />
#scoop v0.2xx
<br />
setlocale(LC_ALL, \'en_US.UTF8\');
<br /><br />
//Include all your personal functions here after u place them in the applibs folder use loadAppLib($file) to load or include
<br /><br /><br />

if(trim($_SERVER[\'scRouteConfig\']) == \'On\'){<br />
&nbsp;&nbsp;require LIB_PATH.\'route.php\';<br />
}<br />
else{<br />
&nbsp;&nbsp;require LIB_PATH.\'noRoute.php\';<br />
}

<br /><br />
?>

</p>
            </div>
</div>
'."
<div style\"margin:4px auto;\" >
Copyright  skipnet&copy; applications. A skiplog design.
</div >

</body>
</html>
");
    }
}

//checks if post or get value is not null
function check_post_get($post_or_get, $key = null, $value = null){
    if(trim($post_or_get) == 'get' || trim($post_or_get) == 'g'){
        if(isset($_GET[$key]) && trim($_GET[$key]) != ''){
            if(trim($value) != ''){
                if(trim($_GET[$key]) == "$value"){
                    return true;
                }
                return false;
            }
                return true;
            }
    }
    if(trim($post_or_get) == 'post' || trim($post_or_get) == 'p'){
        if(isset($_POST[$key]) && trim($_POST[$key]) != ''){
            if(trim($value) != ''){
                if(trim($_POST[$key]) == "$value"){
                    return true;
                }
                return false;
            }
                return true;
            }
    }
    return false;
}


/**
 * Return array of $_GET and $_POST data
 * @return array
 */
function parse_params()
{
    $params = array();

    if (ini_get('magic_quotes_gpc') == 1) {
        if (!empty($_POST)) {
            $params = array_merge($params, stripslashes_deep($_POST));
        } else {
            $params = array_merge($params, $_POST);
        }

    }

    if (ini_get('magic_quotes_gpc') == 1) {
        if (!empty($_GET)) {
            $params = array_merge($params, stripslashes_deep($_GET));
        } else {
            $params = array_merge($params, $_GET);
        }

    }
    return $params;
}



/*******************************************************************************************88
*Function that comverts strings t to acsii.
* http://cubiq.org/the-perfect-php-clean-url-generator
* @author
* @param string $str - string to be worked on
* @param array $replace - array of characters to be stripped out
* @param delimiter - what the characters should be replaced with
********************************************************************************************99*/
function toAscii($str, $replace = array(), $delimiter = null)
{
    if (!empty($replace)) {
        $str = str_replace((array )$replace, ' ', $str);
    }

    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
}

//lesser options
//toAsciiMed("i'll be back") or toAsciiMed("i'll be-- --back") to "i-ll-be-back"
function toAsciiMed($str, $delimiter = null)
{
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
}


function toAsciiMin($str)
{
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_| -]+/", '-', $clean);

    return $clean;
}
/********************************************************************************
********************************************************************************/


/**
 * format date month
 * @param mysql timestamp $mysql_timestamp
 * @return string
 */
function format_date_month($mysql_timestamp)
{
    $unix_time = strtotime($mysql_timestamp);
    return date('M j', $unix_time);
}

function format_date_month_year($mysql_timestamp)
{
    $unix_time = strtotime($mysql_timestamp);
    return date('j M Y', $unix_time);
}

/**
 * format month year
 * @param mysql timestamp $mysql_timestamp
 * @return string
 */
function format_month_year($mysql_timestamp)
{
    $unix_time = strtotime($mysql_timestamp);
    return date('M Y', $unix_time);
}

   function safe_output($string){
    return htmlentities($strings);
}


//Get browser info
function getBrowserOS() { 

    $user_agent     =   $_SERVER['HTTP_USER_AGENT']; 
    $browser        =   "Unknown Browser";
    $os_platform    =   "Unknown OS Platform";

    // Get the Operating System Platform

        if (preg_match('/windows|win32/i', $user_agent)) {

            $os_platform    =   'Windows';

            if (preg_match('/windows nt 6.2/i', $user_agent)) {

                $os_platform    .=  " 8";

            } else if (preg_match('/windows nt 6.1/i', $user_agent)) {

                $os_platform    .=  " 7";

            } else if (preg_match('/windows nt 6.0/i', $user_agent)) {

                $os_platform    .=  " Vista";

            } else if (preg_match('/windows nt 5.2/i', $user_agent)) {

                $os_platform    .=  " Server 2003/XP x64";

            } else if (preg_match('/windows nt 5.1/i', $user_agent) || preg_match('/windows xp/i', $user_agent)) {

                $os_platform    .=  " XP";

            } else if (preg_match('/windows nt 5.0/i', $user_agent)) {

                $os_platform    .=  " 2000";

            } else if (preg_match('/windows me/i', $user_agent)) {

                $os_platform    .=  " ME";

            } else if (preg_match('/win98/i', $user_agent)) {

                $os_platform    .=  " 98";

            } else if (preg_match('/win95/i', $user_agent)) {

                $os_platform    .=  " 95";

            } else if (preg_match('/win16/i', $user_agent)) {

                $os_platform    .=  " 3.11";

            }

        } else if (preg_match('/macintosh|mac os x/i', $user_agent)) {

            $os_platform    =   'Mac';

            if (preg_match('/macintosh/i', $user_agent)) {

                $os_platform    .=  " OS X";

            } else if (preg_match('/mac_powerpc/i', $user_agent)) {

                $os_platform    .=  " OS 9";

            }

        } else if (preg_match('/linux/i', $user_agent)) {

            $os_platform    =   "Linux";

        }

        // Override if matched

            if (preg_match('/iphone/i', $user_agent)) {

                $os_platform    =   "iPhone";

            } else if (preg_match('/android/i', $user_agent)) {

                $os_platform    =   "Android";

            } else if (preg_match('/blackberry/i', $user_agent)) {

                $os_platform    =   "BlackBerry";

            } else if (preg_match('/webos/i', $user_agent)) {

                $os_platform    =   "Mobile";

            } else if (preg_match('/ipod/i', $user_agent)) {

                $os_platform    =   "iPod";

            } else if (preg_match('/ipad/i', $user_agent)) {

                $os_platform    =   "iPad";

            }

    // Get the Browser

        if (preg_match('/msie/i', $user_agent) && !preg_match('/opera/i', $user_agent)) { 

            $browser        =   "Internet Explorer"; 

        } else if (preg_match('/firefox/i', $user_agent)) { 

            $browser        =   "Firefox";

        } else if (preg_match('/chrome/i', $user_agent)) { 

            $browser        =   "Chrome";

        } else if (preg_match('/safari/i', $user_agent)) { 

            $browser        =   "Safari";

        } else if (preg_match('/opera/i', $user_agent)) { 

            $browser        =   "Opera";

        } else if (preg_match('/netscape/i', $user_agent)) { 

            $browser        =   "Netscape"; 

        } 

        // Override if matched

            if ($os_platform == "iPhone" || $os_platform == "Android" || $os_platform == "BlackBerry" || $os_platform == "Mobile" || $os_platform == "iPod" || $os_platform == "iPad") { 

                if (preg_match('/mobile/i', $user_agent)) {

                    $browser    =   "Handheld Browser";

                }

            }

    // Create a Data Array

        return array(
            'browser'       =>  $browser,
            'os_platform'   =>  $os_platform
        );

}


/**
 * Trancate strings
 * Shortens strings
 * @param string
 * @param length
 * @author skipper
 */
 
 function trancate_string($string, $length){
    return trim(substr(substr($string,0,strrpos($string,' ')),0,$length));
 }