<?php

//takes an array and removes all empty value keys
/**
 *@abstract function that removes all empty keys in an array
 *@author skipper
 *@param array
 */
function AlertsArrayRemoveEmpty($arr)
{
    if (isset($arr)):
        if (!is_array($arr)) {
            echo "Make sure the parameter is an array ";
        } else {
            $arr = array_filter($arr);
        }

        return $arr;
    endif;
}


//takes an array and removes all empty value keys
/**
 *@abstract function that removes all empty keys in an array and returns them in order
 * keys will be replaced by indexed keys
 *@author skipper
 *@param array
 */
function AlertsArrayRemoveEmptyOrder($arr)
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


#doc
#	classname:	Error
#	scope:		PUBLIC
#
#/doc

class Alerts
{
    #internal variables
    public $nextWarning;
    public $nextNotice;
    public $notice = array();
    public $display;
    var $myself;


    function __constructor()
    {
        $this->nextWarning = 0;
        //	$this->nextNotice;
        //  $this->myself = new Alerts($this);

    }

    function nextNotice()
    {
        if (!isset($this->nextNotice)) {
            $this->nextNotice = 0;
        } else {
            $this->nextNotice = ++$this->nextNotice;
        }
        return $this->nextNotice;
    }

    public function displayAlerts()
    {
        $d = array();

        $_SESSION['flash'] = AlertsArrayRemoveEmptyOrder($this->notice);
        if (count($this->notice) > 0) {
         //  $_SESSION['flash'] = $this->notice;

            for ($msg = 0; $msg <= count( $_SESSION['flash']); $msg++) {
                $display = AlertsArrayRemoveEmpty((explode(' ', $_SESSION['flash'][$msg])));
                $styler = (explode('"', array_pop(explode('=', $display[3]))));

                if (isset($_SESSION['flash'][$msg])):
                   echo $_SESSION['flash'][$msg];
                    $_SESSION['flash'][$msg] = null;

/*
                    echo "
<style type=\"text/css\">
.exit$msg:hover{
    background:#ccc;
}
</style>
<script type=\"text/javascript\">

    $('<span class=\"exit$msg\" style=\"float:right; background: #8080FF; color: #fff; text-transform: capitalize; margin-top:-5px; font-weight:bolder;padding-left:6px; padding-right:6px;cursor: pointer;\">X</span>').appendTo('span#$styler[1]');

    $('span#$styler[1]').hide().slideDown(320);
    $('span.exit$msg').click(function(){
       $(this).parent('span#$styler[1]').slideUp(250);
    });
</script>

";
 */
 endif;
            }

        }
    }

    public static function unsuccessfullNotice($msg = null)
    {
        $false = " Could not complete the action. ";
        $false .= $msg;
        if (!$false) {
            return false;
        }
    }

    public static function successfullNotice($msg)
    {
        $true = " Successfully completed action. ";
        $true .= $msg;

        if (!$true) {
            return false;
        }
        $_SESSION['flash']['notice'] = $true;
        return true;
    }

    /**
     * sets notice msg used for success
     * @param string $msg
     * @return bool
     */
    public function flashNotice($msg = null)
    {
        $this->flash($msg, 'notice');
    }

    public function flash($msg = null, $mode = null, $closable = null)
    {
        if (isset($mode)) {
            $this->display = $mode;
            ${$mode} = $this->display;
            if (trim($msg) != '') {
                $this->getMsg($msg);
            } else {
                $this->display = 'default';
                if (trim($msg) != '') {
                    return $this->getMsg($msg);
                }
            }
        } else {
            $this->display = 'warning';
            ${$mode} = $this->display;

            return $this->getMsg("Wrong use of flash method: no mode declared");
        }
    }

    public function flashCustom($msg = null, $mode = null)
    {
        if (isset($mode) && trim($mode) != '') {
            $this->flash($msg, $mode);
        } else {
            $mode = 'default';
            $this->flash($msg, $mode);
        }
    }

    private function getMsg($msg)
    {
        global $__STRICT;
        if ($__STRICT['STRICT_ERROR_DISPLAY'] == true) {
            $this->notice[$this->nextNotice()] = "<span class=\"" . $this->display . "\" id=\"" .
                $this->display . $this->nextNotice() . "\"><b class=\"alert\">!</b> " . $msg .
                "</span>
                        <br />
                        ";
        } else {
            $this->notice[$this->nextNotice()] = "<span class=\"" . $this->display . "\"  id=\"" .
                $this->display . $this->nextNotice() . "\"> " . $msg . "</span>
                        <br />
                        ";
        }
    }

    function appFlash($msg = null, $mode = null)
    {
        global $__STRICT;
        if ($__STRICT['APP_ERROR_DISPLAY'] == true) {
            $__STRICT['STRICT_ERROR_DISPLAY'] == true;
            if (isset($mode)) {
                $this->display = $mode;
                if (trim($msg) != '') {
                    $this->getMsg($msg);
                } else {
                    $this->display = 'default';
                    if (trim($msg) != '') {
                        $this->getMsg($msg);
                    } else {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
    }

    /**
     * creates warning msg used for errors.
     * @param string $msg
     * @return bool
     */
    public function flashWarning($msg)
    {
        $this->flash($msg, 'warning');
    }

    public function flashStrictWarning($msg)
    {
        $msg = "<b class=\"alert\">!</b> " . $msg;
        $this->flash($msg, 'warning');
    }

    public function flashStrictNotice($msg)
    {
        $msg = "<b class=\"alert\">!</b> " . $msg;
        $this->flash($msg, 'notice');
    }


    function systemWarning($msg = null)
    {
        if (isset($msg)) {
            $msg = '<b>System:- </b>' . $msg;
        }
        $this->appFlash($msg, 'warning');
    }

    function systemNotice($msg = null)
    {
        if (isset($msg)) {
            $msg = '<b>System:- </b>' . $msg;
        }
        $this->appFlash($msg, 'notice');
    }


    public function resetAlerts()
    {
        for ($i = 0; $i < count($this->notice); $i++):
            $this->notice[$i] = '';
        endfor;

        for ($i = 0; $i < count($_SESSION['flash']); $i++):
            $_SESSION['flash'][$i] = '';
        endfor;

        AlertsArrayRemoveEmpty($this->notice);
        AlertsArrayRemoveEmpty($_SESSION['flash']);

    }


//Array Functions extracted from functions
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


//Filter index and values


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

}

?>