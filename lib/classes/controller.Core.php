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
* Base controller class file
* Location: lib/classes/controller.Core.php
*/

@include 'logsClass.php';
class aztrasController{

    protected $load;
    protected $model;
    protected $logs;

    function __construct(){
    $this->model = get_class($this).'Model';
    
    $this->load = new aztrasLoader(get_class($this));
    if(class_exists($this->model)):
    $this->model = new $this->model;
    endif;
    
    if(class_exists('logs')):
    $this->logs = new logs();
    endif;
    }
    
    

}