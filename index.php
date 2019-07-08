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

session_start();
//error_reporting(E_ALL);
//ini_set('display_errors',1);
ob_start();

//start app
include_once ('config/constants.php');
require 'config/config.php';
include 'libsLoader.php';
require 'core.php';

//load aplication index ( application/inex.php)
loadAppIndex();
reset_flashes();
ob_flush();
