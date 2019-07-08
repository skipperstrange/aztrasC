<?php

require_once 'config/routes.php';

// Requested URL
$url = $_SERVER['REQUEST_URI'];

// Removes Apllication root from url
$url = str_replace('/' . APP . '/', '', $url);

// holds the named captures, $_POST data
$params = parse_params();

// Removes query string from $url we don't need it anymore affect routes.
$url = str_replace('?' . $_SERVER['QUERY_STRING'], '', $url);

//  becomes true if $route['url'] matches $url
$route_match = false;

// loops over $routes looking for a match
for ($i = 0; $i < count($_SERVER['scROUTES']); $i++) {
    $route = $_SERVER['scROUTES'][$i];

    // if match found appends $matches to $params
    // sets $route_match to true and also exits loop.
    if (preg_match($route['url'], $url, $matches)) {


        $params = array_merge($params, $matches);
        $_SERVER['DEFAULT_VIEW'] = $view = $route['view'];
        $_SERVER['DEFAULT_CONTROLLER'] = $controller = $route['controller'];
        $_GET = array_merge($_GET, $params);

        $route_match = true;
        break;
    }

}

// if no route matched display error 404
if (!$route_match) {
    $url_not_found = str_replace(DS . APP, '', $_SERVER['REQUEST_URI']);

    die("
<html>
<head>
<title>404 Not Found</title>
</head>
<body style=\"font:arial;font-size:97%;margin:0px auto;\">

<div style=\"width:90%;margin:auto; padding:40px;\">
<div style=\"border:solid 1px #b7d4f7;width:100%;background:#ddebfc;margin:5px auto;padding:15px;\">
<h1>Oooops! Page does not exist!</h1>
<span>
Sorry, the requested URL $url_not_found you are looking for does not exist on this server at the momment.
kindly return to whence you came from. :)

<hr />
<address>
$_SERVER[SERVER_SIGNATURE] Server at  $_SERVER[SERVER_NAME] $_SERVER[SERVER_PORT]
</address>
</span>
<br />
</div>

<div style=\"margin:4px auto;width:100%;text-align:center;\" >
Copyright aztrasC&copy;  skipnet&copy; applications 2011 - ". strftime('%Y',time())."
</div >

</body>
</html>
        ");
}

// include controller
if (file_exists(strtolower(CONTROLLER_PATH . $_SERVER['DEFAULT_CONTROLLER']) .
    '.Controller.php')) {

    // echo $controller.' '.CONTROLLER_PATH.$_SERVER['DEFAULT_CONTROLLER'];
    if (require_once strtolower(CONTROLLER_PATH . $_SERVER['DEFAULT_CONTROLLER']) .
        '.Controller.php') {
        $controller = ucfirst($_SERVER['DEFAULT_CONTROLLER']);
        $aztrasController = new $controller;
        if (method_exists($aztrasController, $view)) {
            $aztrasController->$view();
        } else {
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

    } else {
        exit("<h1>Oops! Could not load controller ($controller).</h1>
    Please contact the system administrator or program vendor!
    ");
    }

} else {
    exit("<h1>Oops! The controller ($controller) does not exist</h1>
    Please contact the system administrator or program vendor!
    ");
}

