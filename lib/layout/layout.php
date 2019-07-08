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
$STP_HTML->comment('body starts here.');
$STP_HTML->oTag('body');

//Header div starts here. First comment the div
$STP_HTML->comment('header start');
$STP_HTML->oTag('header', 'class,row');


$STP_HTML->oDiv('class,col-lg-3 | style,background:#ccc;');
$STP_HTML->comment('id nav start');
$STP_HTML->oDiv('id,nav'); 

$STP_HTML->a('administrator',WEB_URL.'appadmin/index.php');


$STP_HTML->span('powered by spoop v'.VERSION,'style,color: #555; float:right; font-style: italic;text-shadow:#ccc 1px 1px 1px;  font-weight: bolder; ');
$STP_HTML->cDiv();
$STP_HTML->cDiv();
$STP_HTML->comment('end nav');
//end nav

//Logo tins
$STP_HTML->oDiv('class,col-lg-6');
$STP_HTML->h1('Welcome to aztrasC.');
$STP_HTML->cDiv();


$STP_HTML->cTag('header');
$STP_HTML->comment('end header');//end of header

//content starts here
$STP_HTML->comment('start container');
$STP_HTML->oDiv('class, container');

$STP_HTML->comment('page content');
$STP_HTML->oDiv('class,row');

$STP_HTML->comment('start content');
$STP_HTML->oDiv('id,content | class,col-lg-10 | id,fb-root');
$STP_HTML->comment('warnings and notices');
//single time use notices
display_flashes();
//Multiple uses
$ALERTS->displayAlerts();

//pages will load here

    