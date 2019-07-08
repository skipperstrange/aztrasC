<?php

class Validate
{


    static function form_validate($params, $return_msg = null, $str_length = null)
    {
        $error = 0;

        if ($params)
            foreach ($params as $key => $value) {
                if (trim($value) != '') {
                    if (!preg_match('/[a-zA-Z0-9]+$/', ($key))) {
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

                if (isset($str_length) && trim($str_length) != ''):
                    if (is_int($str_length)) {
                        if (strlen($value) < $str_length) {
                            $msg .= "<p><span  style=\"font-size:11px;\">* " . ucwords(preg_replace('/_/',
                                ' ', preg_replace('/-/', ' ', $key))) . " field cannot be less than $str_length characters </span></p>";
                            $error++;
                        }
                    } else {
                        echo 'Third validation parameter str_length requires an intiger.';

                    }
                endif;

            }
        if ($error > 0) {
            $msg .= '<span style="color:red;">There are errors with your input(s)</span>';
            if (isset($msg)) {
                if (isset($return_msg)) {
                    if ($return_msg == 1) {
                        return $msg;
                    } elseif ($return_msg == 0) {
                        return false;
                    } else {
                        echo $msg;
                    }

                }
            }

        } else {

            return true;
        }
    }


    function validate_email($email, $return_msg = null)
    {
        $error = 0;
        if (!eregi('([_\.0-9a-z-]+@)([0-9a-z][0-9a-z]+\.)+([a-z]{2,3})',$email)) {
            $msg = "Invalid email address!";
            $error++;
        }

        if ($error > 0) {
            if (isset($msg)) {
                if (isset($return_msg)) {
                    if ($return_msg == 1) {
                        return $msg;
                    } elseif ($return_msg == 0) {
                        return false;
                    } else {
                        echo $msg;
                        return false;                        
                    }

                }
            }
        }else{
            return true;
        }
    }
    
    function validate_url($url, $return_msg = null)
    {
        $error = 0;
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $msg .= "Invalid url!";
            $error++;
        }

        if ($error > 0) {
            if (isset($msg)) {
                if (isset($return_msg)) {
                    if ($return_msg == 1) {
                        return $msg;
                    } elseif ($return_msg == 0) {
                        return false;
                    } else {
                        echo $msg;
                    }

                }
            }
        }else{
            return true;
        }
    }
    
    static function formatTelNumber($number, $CountryCode, $strict = null ,$cityCode = 0)
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

}

?>