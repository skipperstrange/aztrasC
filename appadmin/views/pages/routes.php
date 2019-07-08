<style>
table tr:hover{
background: #ddd;
 }
 </style>
<script>
 function deleteRouteEntry(route_id){
    $('#'+route_id).empty();
 }
</script>

<div>
<b>Route status:</b> <?php
$colors = array('#f3f5ff','#f4f6ff');
echo $_SERVER['scRouteConfig'];
if($needed == 1){ echo '- Routes file does not exist. click Reset to create it.';}
?>
&nbsp;&nbsp;&nbsp;&nbsp;<b>Available Routes:</b> (<?php echo count($_SERVER['scROUTES']); ?>)
<span style="margin-top: 5px;font-size: 11px; color: #999;">
<br />
route_settings.php and routes.php file can be found in config folder of application root.
<br />
Advanced: routes.php can be edited manually. knowledge of php regurlar expression is required. 
</span>
<span style="float: right;"><?php if($_SERVER['scRouteConfig'] == 'Off'){ ?>
<a class="button" href="index.php?view=routes&route=on">Enable Routes</a>
<?
}else{
?>
<a class="button" href="index.php?view=routes&route=off">Disable Routes</a>
<?php
}
?>

<a href="index.php?view=routes&reset=true" class="button">Reset Routes</a>

<a href="index.php?view=routes&default=true" class="button">Load Defaults</a>
</span>
</div>
<br />
<?php
$form = new stpForms;

if($_POST['r'] || $_POST['gr'] || $_POST['os']):

echo $confirm_form;
echo
     "<span style=\"float:right;\">
     <a class=\"button\" href=\"index.php?view=routes\">Manually create routes</a>
     <a class=\"button\" href=\"index.php?view=routes&autogen=true\">Auto Generate Routes</a>
     </span>";

else:

if(isset($_GET['autogen']) && trim($_GET['autogen'])==true):
?>

<script type="text/javascript">
$(function(){
     <?php
   if(isset($_POST['controller']) && trim($_POST['controller']) != ''):
   ?>
   $('div#methods').show();
   <?php
   else:
   ?>
   $('div#methods').hide();
   <?
   endif;
   ?>

});
//function $(i){return document.getElementById(i)}
function frefresh(){
 var F=document.autogen;
/* F.method='post';
 F.refresh.value="1";*/
 F.submit(); 
}

function trefresh(){
 var F=document.DF;
 F.method='get';
 F.refresh.value="1";
 F.submit();
}
</script>

<h2>
Auto Generate controller routes:
</h2>
<a style="float:right;" class="button" href="index.php?view=routes">Manually create routes</a>
<form id="autogen" name="autogen" action="index.php?view=routes&autogen=true#" method="POST">
<select id="controller" name="controller" onChange="frefresh();">
<?php
if(isset($_POST['controller']) && trim($_POST['controller']) != ''):

?>
<optgroup label="Current Controller">
<?php $form->option($_POST['controller'],'value,'.$_POST['controller']); ?>
</optgroup>
<?php

endif;
?>
<optgroup label="Availible Controllers">

<?php

foreach($controllers as $controller):
$controller = str_replace('.Controller.php','',$controller);
    $form->option($controller,'value,'.$controller);
endforeach;
?>
</optgroup>
</select>

  <div id="methods">
  <?php
  if(count($class_methods) > 0):
  ?>
	Select Methods :
    <table width="95%" border="0">
    <tr  bgcolor="#b7c2f7">
    <td></td><td width="5%">Select</td><td width="25%">Method</td><td>Parameters</td>
    </tr>
    <?php
    
    foreach($class_methods as $index => $method):
    if($method != '__construct'):
    echo "<tr>
    ";
    echo "<td>$index</td>
    ";
    echo "<td><input type=\"checkbox\" name=\"$method"."[route]\" title=\"Tick to create pretty url for $method\"></td>
    ";
    echo "<td>$method</td>
    ";
    echo "<td><input size=\"50\" name=\"$method"."[params]\" value=\"".$_POST[$method."[params]"]."\" placeholder=\"?".$method."_param1&".$method."_param2\" title=\"example: ".$method."_param1&".$method."_param2&".$method."_param3...\" /></td>
    ";
    echo "</tr>";
    endif;
    endforeach;
    ?>
    </table>
 <?php
 else:
 
 endif;
 ?>
 </div>
 <br />
<input type="submit" name="gr" value="Generate Routes" /> &nbsp;&nbsp;&nbsp;<input type="checkbox" name="all" value="generateall" checked="checked" /> Generate all possible routes.
 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="rw" value="overwrite" /> Overwrite routing table.
</form>
<?php 
else:
?>
<h2>
Add New Route:
</h2>
<form action="index.php?view=routes#" method="POST">
<select name="route[controller]">
<option value="">
Choose controller
</option>
<?php
foreach($controllers as $controller):
$controller = str_replace('.Controller.php','',$controller);
    $form->option($controller,'value,'.$controller);

endforeach;
?>
</select>

&nbsp; <b>View:</b>
<input name="route[view]" value="<?php if($ee>0){echo $_POST['route']['view'];} ?>" />

&nbsp; <b>Url Pattern or params:</b> <input name="route[url]" size="26" value="<?php if($ee>0){echo $_POST['route']['url'];} ?>" placeholder="?param1&param2&param3 or full url" />
<br /><br /><input type="checkbox" name="all" value="generateall" checked="checked" /> Generate all possible routes.
<br/>
<br />
<input type="submit" name="r" value="Add Route" /> <a style="float:right;" class="button" href="index.php?view=routes&autogen=true">Auto Generate Routes</a>
</form>
<?php
endif;

endif;
?>
<span style="margin-top: 5px;font-size: 11px; color: #999;">route parameters examples:<br />
/sites/(?P&lt;variablename&gt;\w+)/(?P&lt;intiger&gt;\d+)/....<br /> or :
?controller=controller&amp;view=view&amp;parameter1&amp;parameter2&amp;parameter3...
<br />
or: Just select controller and view, then add parameters by filling in '?parameter1&amp;parameter2&amp;parameter3...'
</span>

<br /><br />
<?
$BackupForm = new stpForms;

$BackupForm->b('Backup Routes');
$BackupForm->oDiv();
$BackupForm->startForm('#','POST');

?>
<!-- javascript to hide av_routes -->
<script type="text/javascript">
$(function(){
  // return false;
  //  $('div#av_routes').hide();
    });

</script>

<label>Backup Name</label> :
<input name="backup[name]" value="<?php echo $_POST['backup']['name']; ?>" />
<?
$BackupForm->submit('Backup','name,bckp');

$BackupForm->endForm();

$BackupForm->cDiv();
?>
<div style="clear: both; margin-top: 10px;">
<a href="#" onclick="toggleHideDiv('id','av_routes')">Show/Hide Routes</a>
</div>
<div id="av_routes">
<h2>Available Routes (<?php echo count($_SERVER['scROUTES']); ?>)</h2>

<?php
if(count($_SERVER['scROUTES']) > 0):
?>
<table cellpadding="2px" width="100%" border="0">
<tr bgcolor="#b7c2f7">

<td width="3%"><b>no.</b></td><td width="20%"><b>controller</b></td><td width="20%"><b>view</b></td><td width="35%"><b>url</b></td><td></td>
</tr>
<?php
for($i=0;$i<count($_SERVER['scROUTES']);$i++):
echo "<tr bgcolor=\"".$colors[($i)%count($colors)]."\">
";

echo "<td >".($i+1)."</td>
<td>".$_SERVER['scROUTES'][$i]['controller']."</td>
<td>".$_SERVER['scROUTES'][$i]['view']."</td>
<td>".htmlentities(ltrim(rtrim($_SERVER[scROUTES][$i][url],'$@'),'@^'))."</td>

<td><!--<a href=\"routes\">edit</a> --><a href=\"index.php?view=routes&delete=".($i)."\">delete</a></td>
";
echo "</tr>
";
endfor;
?>
</table>
<?php
endif;
?>
</div>

<div style="clear: both; text-align: right; margin-top: 20px; border-top: #999 solid 1px; padding-top: 8px;">
<span style="float: left; text-align: left;">

<?php
$BackupForm = new stpForms;

$BackupForm->b('Backup Routes');
$BackupForm->oDiv();
$BackupForm->startForm('#','POST');

?>
<label>Backup Name</label> :
<input name="backup[name]" value="<?php echo $_POST['backup']['name']; ?>" />
<?
$BackupForm->submit('Backup','name,bckp');
?>
<a href="#" onclick="toggleHideDiv('id','backuedup')">Show/Hide Backups</a>
<?

$BackupForm->endForm();

$BackupForm->cDiv();
?></span>
<?php if($_SERVER['scRouteConfig'] == 'Off'){ ?>
<a class="button" href="index.php?view=routes&route=on">Enable Routes</a>
<?
}else{
?>
<a class="button" href="index.php?view=routes&route=off" >Disable Routes</a>
<?php
}
?>
<a href="index.php?view=routes&reset=true" class="button">Reset Routes</a>
<a href="index.php?view=routes&default=true" class="button">Load Defaults</a>

</div>

<script type="text/javascript">
$(function(){
  // return false;
    $('div#backuedup').hide();
    });

</script>
<br />
<div id="backuedup">
<h2>Saved Routes</h2>
<a href="index.php?view=routes&deleteallbackups=true" style="float: right;">Delete All Backups</a>
<?php
foreach($BackupFolder as $folder => $backUps):
$i=0;
?>
<table width="800px" border="0">
<tr>
<td colspan="20" bgcolor="#b7c2f7"><b style="border-bottom: #ccc solid 1px;"><?php echo $folder; ?> backed up routes (<?php echo count($BackupFolder[$folder]['backups']) ?>)</b></td>
</tr>
<?php
foreach($BackupFolder[$folder]['backups'] as $backUp){

?>
<tr>
<td bgcolor="<?php echo $colors[($i)%count($colors)]; $i++;?>" width="80%"><?php echo $backUp; ?></td>
<td bgcolor="<?php echo $colors[($i)%count($colors)]; $i++;?>">
<a href="index.php?view=routes&deletbackup=true&type=<?php echo $folder;?>&backup=<?php echo $backUp; ?>">delete</a>
 |
<a href="index.php?view=routes&restore=true&type=<?php echo $folder;?>&backup=<?php echo $backUp; ?>">restore</a>
</td>
</tr>
<?php
}
?>
</table>
<br />
<?php
endforeach;
?>

</div>