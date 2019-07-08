<?php
#
#Default Site home settings. Here we define
#the default home of the site.
#

$DEFAULT_CONTROLLER = APP;
$DEFAULT_VIEW = 'index';

$_SERVER['DEFAULT_VIEW'] = empty($_GET['view']) ? $DEFAULT_VIEW : $_GET['view'];
$_SERVER['DEFAULT_CONTROLLER'] = empty($_GET['controller']) ? $DEFAULT_CONTROLLER : $_GET['controller'];