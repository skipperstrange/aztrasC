<?php
#scoop v0.2xx
setlocale(LC_ALL, 'en_US.UTF8');
global $SESSION;

//Include all your personal function files here after you place them in the applibs folder use loadAppLib($file) to load or include
//End of custom files
@include 'applibs/fb.php';

//Custom code that affects the whole site
//End of custom code


if (trim($_SERVER['scRouteConfig']) == 'On') {
    require LIB_PATH . 'route.php';
} else {
    require LIB_PATH . 'noRoute.php';
}

 