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
* Also under the developer's notice under his terms and or regulations <skipperstrange@gmail.com>
*
* Read the full licence: http://www.opensource.org/licenses/lgpl-license.php
*
* Library loader
* Location: libsLoader.php
*/

include (CLASSES_PATH.'fileSystemClass.php');
include (CLASSES_PATH.'phpFileSystemClass.php');
PhpFileSys::include_all_files_once(FUNCTIONS_PATH);
include CLASSES_PATH.'stpHtml/stp.php';
@include_once CLASSES_PATH.'classes/tc_calendar.php';
include CLASSES_PATH.'alertsClass.php';
include_once LIB_PATH.'adaptorsLoader.php';
include_once CLASSES_PATH.'autoLoad.php';
PhpFileSys::include_all_files_once(CLASSES_PATH);
include_once LIB_PATH.'modelsLoader.php';

//load Class that can detect device type
include (LIB_PATH.'deviceDetect.php');
//Start up other initializations before app starts
include (LIB_PATH.'startup.php');
