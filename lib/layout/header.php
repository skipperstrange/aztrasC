<?php
global $STP_HTML;
global $ALERTS;
global $controller;

//Setting doctype
$STP_HTML->html5_state();

//startin html
$STP_HTML->html5_begin('xmlns:fb,http://www.facebook.com/2008/fbml');

##Setting anything that needs to go in the head e.g. css, js , meta
$STP_HTML->add_meta('charset,utf-8');
$STP_HTML->add_meta('name,viewport |content,width=device-width % initial-scale=1.0');
#$STP_HTML->add_meta('info,value|info,value');
$STP_HTML->add_css(WEB_URL.'public/css/bootstrap.min.css');
//$STP_HTML->add_css(WEB_URL.'public/css/style.css');
$STP_HTML->add_css(WEB_URL.'public/css/custom.css');
$STP_HTML->add_js(WEB_URL.'public/js/respond.js');


//This constructs the head of the html. all css, meta etc should be set before this line in order
//to auto load. Failure to do so would mean you'd probably have to do so manually via $STP_HTML->meta() function.
$STP_HTML->set_head();


//Starting Html body -> layout.php

