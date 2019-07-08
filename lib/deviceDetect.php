<?php

$device = new Mobile_Detect();
if (!isset($_SESSION['device_type'])) {


    if ($device->isMobile()) {
        //$_SESSION['device_type'] = 'mobile';
        $_SESSION['device_type'] = 'mobile';
        
         foreach ($device->getOperatingSystems() as $device_os => $os) {
                $os_check_function = 'is' . $device_os;
                //echo $os_check_function.'<br/>';
                if ($device->$os_check_function()) {
                    $_SESSION['device_os'] = $device_os;
                }
         }
        
        
        if ($device->isiOS()) {
                $d = getBrowserOS();
                $_SESSION['device_type'] = $d['os_platform'];
            }

        } elseif ($device->isTablet()) {
            $_SESSION['device_type'] = 'tablet';
             $d = getBrowserOS();
                $_SESSION['device_type'] = $d['os_platform'];
        } else {
            $_SESSION['device_type'] = 'pc';
             $d = getBrowserOS();
             $_SESSION['device_os'] = $d['os_platform'];
        }

//print_r($device->getRules());

foreach($device->getTabletDevices() as $model => $dev){
    $os_check_function = 'is' . $model;
                //echo $os_check_function.'<br/>';
                if ($device->$model()) {
                    $_SESSION['device_type'] = $model;
                }
}

foreach ($device->getOperatingSystems() as $device_os => $os) {
                $os_check_function = 'is' . $device_os;
                //echo $os_check_function.'<br/>';
                if ($device->$os_check_function()) {
                    $_SESSION['device_os'] = $device_os;
                }
         }

}
//session_destroy();

?>