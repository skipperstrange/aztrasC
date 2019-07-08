<?php

/**
 * All form Validations go here
 * 
 **/


function form_validate_($params)
{
    $error = false;

    if ($params)
        foreach ($params as $key => $value) {
            if (trim($value) != '') {
                if (!preg_match('/[a-zA-Z0-9]+$/', ($value))) {
                    echo "<p><span  style=\"font-size:90%;\"> $value is not valid for your ".ucwords(preg_replace('/_/', ' ', preg_replace('/-/', ' ', $key))) ." name only alphanumeric characters allowed</span></p>";
                    $error = true;

                }
            } else {
                echo "<p><span style=\"font-size:90%;\">* " . ucwords(preg_replace('/_/', ' ', preg_replace('/-/', ' ', $key))) .
                    " field cannot be left blank </span></p>";
                $error = true;
            }

        }
    if ($error == true) {
        echo '<span class="warning">There are errors with your input(s)</span>';
        return  false;
    } 
}


function formatTelNumber($number, $CountryCode, $strict = null ,$cityCode = 0)
{
    //First remove all spaces
    $number = trim($number);
    //create container for collecting digits
    $tel = array();

    //Removing 0's and none required digits from front of number in some countries
    if (preg_match('/^[' . $cityCode . ']{1}/', $number)) {
        for ($k; $k < strlen($number); $k++) {
            array_push($tel, $number[$k]);
        }
        //This is where the front digit gets removed
        array_shift($tel);
        $number = $CountryCode . implode('', $tel);

    } elseif (preg_match('/^[' . $CountryCode . ']{1}/', $number)) {
        $number;
    }

    if (isset($strict)) {
        $number = '+' . $number;
    }
    return $number;
}


function form_validate($params, $return_msg = null,$str_length=null)
    {
        $error = 0;

        if ($params)
            foreach ($params as $key => $value) {
                if (trim($value) != '') {
                    if (!preg_match('/[a-zA-Z0-9]+$/', ($value))) {
                        $msg .= "<p><span  style=\"font-size:11px;\"> $value is not valid for your " .
                            ucwords(preg_replace('/_/', ' ', preg_replace('/-/', ' ', $key))) .
                            " field. Only alphanumeric characters allowed</span></p>";
                        $error++;

                    }
                } else {
                    $msg .= "<p><span  style=\"font-size:11px;\">* " . ucwords(preg_replace('/_/',
                        ' ', preg_replace('/-/', ' ', $key))) .
                        " field cannot be left blank </span></p>";
                    $error++;
                }
                
                if(isset($str_length) && trim($str_length) != ''):
                if(is_int($str_length)){
                    if(strlen($value)<$str_length){
                        $msg .= "<p><span  style=\"font-size:11px;\">* " . ucwords(preg_replace('/_/',
                        ' ', preg_replace('/-/', ' ', $key))) .
                        " field cannot be less than $str_length characters </span></p>";                        
                        $error++;
                         }                             
                }
                else{
                    echo 'Third validation parameter str_length requires an intiger.';
                                    
                 }  
                endif;                                                                

            }
        if ($error > 0) {
            $msg .= '<span style="color:red;">There are errors with your input(s)</span>';
            if (isset($msg)) {

                if (isset($return_msg)) {
                    if($return_msg == 1){
                      return $msg;  
                    }
                    elseif($return_msg == 0) {
                        return false;
                }
                else{
                    echo $msg;
                }
                    
                } 
            }

        } else {

            return true;

        }
    }

?>