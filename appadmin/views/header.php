<?php
//Setting doctype
$STP_HTML->html5_state();

//startin html
$STP_HTML->html5_begin();

##Setting anything that needs to go in the head e.g. css, js , meta
#$STP_HTML->add_meta('name,value|content,value|charset,value');
#$STP_HTML->add_meta('info,value|info,value');
#$STP_HTML->add_css(CSS_PATH.'style.css');
$STP_HTML->add_css('public/css/style.css');
$STP_HTML->add_css('public/css/jquery.mobile-1.0rc2.min.css');
$STP_HTML->add_css('public/css/jquery.mobile-1.0rc2.css');
$STP_HTML->add_js(JS_PATH.'jquery-1.4.3.min.js');
$STP_HTML->add_js(JS_PATH.'jqs_fns.js');



//This constructs the head of the html. all css, meta etc should be set before this line in order
//to auto load. Failure to do so would mean you'd probably have to do so manually via $STP_HTML->meta() function.
$STP_HTML->set_head();


//Starting Html body
$STP_HTML->comment('body starts here.');
$STP_HTML->oTag('body');

$STP_HTML->comment('id container start');
$STP_HTML->oDiv('id,container');

//Header div starts here. First comment the div
$STP_HTML->comment('header id start');

$STP_HTML->oDiv('id,header');
$STP_HTML->h1(APP.'Admin','style,margin-bottom: 0px;font-family:verdana;');
$STP_HTML->span('powered by aztraz','style,color: #999;font-style: italic;text-shadow:#ccc 1px 1px 1px;  font-weight: bolder; margin-left: 10px;');

$STP_HTML->cDiv();
$STP_HTML->comment('end header');
?>