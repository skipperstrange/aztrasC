<?php

$STP_HTML->p('AztrasC is an object oriented uprade of aztras, commonly known as scoopmvc. Instead of switch cases used in controllers, classes are used.');

$STP_HTML->h2('Major upgrade differences.');
$STP_HTML->oTag('ul');
$STP_HTML->li('Setup is done manually in afew steps and code is not auto generated');
	$STP_HTML->li('Controllers in aztrasC are all objects that extend a core controller class.');
	$STP_HTML->li('Views are called by the controller class.');
	$STP_HTML->li('Views are loaded by the controller class ($this->load->view($view_file,$data)).');
	$STP_HTML->li('Option for views option be shared between controllers without templates using ($this->load->view($view_file,$data)).');
	$STP_HTML->li('By default, the controllers have view a folder in application/views/');
	$STP_HTML->li('If a model class in the controller name exists, its auto loaded as controllerModel;');
$STP_HTML->cTag('ul');

$STP_HTML->h2('What\'s new in version '.VERSION);
$STP_HTML->oTag('ul');
        $STP_HTML->li('This version is shipped with botstrap3.');
        $STP_HTML->li('Facebook API has been added with sample controller and views.');
        $STP_HTML->li('Just set controller parameter to afacebook ('.WEB_URL.'?controller=afacebook). ');
        $STP_HTML->oTag('li').$STP_HTML->output('Or just ').$STP_HTML->a('click here','index.php?controller=afacebook').$STP_HTML->output(' to see example.').$STP_HTML->cTag('li');;
$STP_HTML->cTag('ul');

$STP_HTML->output('For a quick tutourial on how to get started on a sample app').$STP_HTML->a('click here','index.php?view=setup');
?>