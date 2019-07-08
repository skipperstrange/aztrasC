<?php
$admin_view = empty($_GET['view']) ?'home' :$_GET['view'];

function stripslashes_deep($value)
{
    $value = is_array($value) ? array_map('stripslashes_deep', $value) :
        stripslashes($value);
    return $value;
}


if(get_magic_quotes_gpc()) {
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);
}

if(file_exists(UP_ONE.ADAPTORS_PATH.'SQL'.DS.'mysql.ad')){
    include_once UP_ONE.ADAPTORS_PATH.'SQL'.DS.'mysql.ad';
}
include '../'.CLASSES_PATH.'view.Core.php';
include '../'.CLASSES_PATH.'model.Core.php';
include '../'.CLASSES_PATH.'controller.Core.php';