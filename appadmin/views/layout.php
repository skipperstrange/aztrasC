<?php

require_once 'header.php';

$STP_HTML->comment('page content');
$STP_HTML->oDiv('id,content');

$STP_HTML->oTag('p');
$STP_HTML->a('Go to site',WEB_URL,'style,float:right;');
$STP_HTML->oDiv('id,main-nav');


$STP_HTML->oTag('ul');

foreach($pages as $page):
echo "<li><a href=\"".'index.php?view='.urlencode(str_replace('.php','',$page))."\">".str_replace('.php','',$page).'</a>';
echo "</li>
";
endforeach;
$STP_HTML->cTag('ul');
$STP_HTML->cDiv();

$STP_HTML->comment('warnings and notices');
//single time use notices
display_flashes();
//Multiple uses
$ALERTS->displayAlerts();

//pages will load here
if (file_exists('views/pages/'.$admin_view . '.php')) {
$STP_HTML->h2('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$admin_view,"style,background:url('public/css/img/".$admin_view."22.png') no-repeat;");
    require ('views/pages/'.$admin_view . '.php');

} else {
    require '404.php';
}


$STP_HTML->cTag('p');
$STP_HTML->cDiv();
$STP_HTML->comment('end page content');


require_once 'footer.php';

?>