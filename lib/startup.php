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
*
* Final startup file
* Location: lib/startup.php
*/


//start up function

// strips out escape characters
function stripslashes_deep($value)
{
    $value = is_array($value) ? array_map('stripslashes_deep', $value) :
        stripslashes($value);
    return $value;
}
if(PHP_VERSION < '5.4'):
if(get_magic_quotes_gpc()) {
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);
}
endif;
$controller = $_SERVER['DEFAULT_CONTROLLER'];
$view = $_SERVER['DEFAULT_VIEW'];


global $controller;
global $view;

$ALERTS = new Alerts;
$STP_HTML = new stpHtml;
$SESSION = new Session;

@include_once 'modelsLoder.php';