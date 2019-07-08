<?php

/*
 * Aztraz/ScoopMinimal - PHP MVC Framework libraries
 *
 * Copyright (C) 20011 Nana Yaw Duah A.K.A Skipper Strange <skipperstrange@gmail.com>
 *
 * Developers:
 *		Nana Yaw Duah A.K.A Skipper Strange <skipperstrange@gmail.com>
 *
 * Contributors:
 *
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the
 * GNU Lesser General Public License as published by the Free Software Foundation.
 *
 * Read the full licence: http://www.opensource.org/licenses/lgpl-license.php
 */

session_start();
//error_reporting(E_ALL);

ob_start();
include_once ('../config/constants.php');
require '../config/config.php';
include '../'.FUNCTIONS_PATH.'fxns.php';
include '../'.FUNCTIONS_PATH.'view_fxns.php';
include '../'.FUNCTIONS_PATH.'model_fxns.php';
include '../'.CLASSES_PATH.'stpHtml/stp.php';
include '../'.CLASSES_PATH.'alertsClass.php';
include '../'.CLASSES_PATH.'fileSystemClass.php';
include '../'.CLASSES_PATH.'validatesClass.php';

include 'startup.php';

$STP_HTML = new stpHtml;
$ALERTS = new Alerts;

global $STP_HTML;
global $ALERTS;

include 'admin.Controller.php';
include_once 'views/layout.php';

reset_flashes();
ob_flush();

?>