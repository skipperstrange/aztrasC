<style>
table tr:hover{
background: #ddd;
 }
 </style>
<div style="width: 400px; clear: right;"><!-- defaults -->
<h2>Defaults</h2>

    <b>
    Default controller:
    </b>
    <?php if(trim($DEFAULT_CONTROLLER) != ''){
        echo '<span style="color:green;">'.$DEFAULT_CONTROLLER.'</span><a href="index.php?view='.$admin_view.'&config='.$_GET['config'].'&unsetcontroller=true"  style="float:right;">....Unset &raquo;</a>';
        }else{
          echo '<span style="color:red;">Not Configured</span>....<a href="#" onclick="toggleHideDiv(\'id\',\'defsettings\'); return false;" style="float:right;">Configure &raquo;</a>';
          $def_controller_needed == 1;
        }
    ?>
<br />
    <b>
    Default view:
    </b>

    <?php  if(trim($DEFAULT_VIEW) != ''){
        echo '<span style="color:green;">'.$DEFAULT_VIEW.'</span><a href="index.php?view='.$admin_view.'&config='.$_GET['config'].'&unsetview=true" style="float:right;">....Unset &raquo;</a>';
        }else{
          echo '<span style="color:red;">Not Configured</span> ....<a href="#" onclick="toggleHideDiv(\'id\',\'defsettings\'); return false;" style="float:right;">Configure &raquo;</a>';
          $def_controller_needed == 1;
        } ?>
<br />
<br />
<a href="#" onclick="toggleHideDiv('id','defsettings',300); return false;" style="float:right;">Modify Defaults</a>

</div>

<!-- end off defaults -->

<?php
if($defer == 0):
?>
<!-- javascript to hide default settings form -->
<script type="text/javascript">
$(document).ready(function(){
  // return false;
    $('div#defsettings').hide();
    });

</script>
<?php
endif;
?>
<br />
<br />

<!--default settings configuration -->
<div id="defsettings" style="margin-top: ;">
<b>
Modify defaults:
</b>
<?php
$form = new stpForms;
$form->startForm();
?>
<select name="route[controller]">
<?php
if(trim($DEFAULT_CONTROLLER) != ''){
    $form->option($DEFAULT_CONTROLLER,'value,'.$DEFAULT_CONTROLLER);
}else{
?>
<option value="">
Choose controller
</option>
<?php
}

foreach($controllers as $controller):
$controller = str_replace('.Controller.php','',$controller);
if($controller != $_SERVER['DEFAULT_CONTROLLER']):
$form->option($controller,'value,'.$controller);
endif;
endforeach;
?>
</select>

&nbsp; View:
<input name="route[view]" value="<?php if($_POST['route']['view']){echo $_POST['route']['view'];}else{echo $DEFAULT_VIEW;} ?>" />

<input type="submit" name="r" value="Save" />
<?php
$form->endForm();
?>

</div>
<br />
<div >Models: <?php echo count($Model_files); ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Controllers: <?php echo count($Controller_files);?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Views: <?php echo count($View_folders);  ?>
<span style="float: right">
<?php if($_GET['config'] != 'controllers'):
?>
<a href="index.php?view=<?= $admin_view; ?>&config=controllers" class="button">controllers</a>
<?php
endif;
if($_GET['config'] != 'models'):
?>
<a href="index.php?view=<?= $admin_view; ?>&config=models" class="button">models</a>
<?php
endif;
if($_GET['config'] != 'views'):
?>
<a href="index.php?view=<?= $admin_view; ?>&config=views" class="button">views</a>
<?php
endif;
/*
if($_GET['config'] != 'generate_mvc'):
?>
<a href="index.php?view=<?= $admin_view; ?>&config=generate_mvc" class="button">new mvc module</a>
<?php
endif;
*/
?>
</span></div>
<hr style=" clear:both;" />
<!--end of default settings configuration-->
<script >
$(document).ready(function(){
    $('div#indmvc').hide().fadeIn(700);
    return false;
    });
</script>

<div id="indmvc">
<?php

if($_GET['config'] && trim($_GET['config']) != ''){
$STP_HTML->h2('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.str_replace('_',' ',$_GET['config']),"style,background:url('public/css/img/".$_GET['config'].".png') no-repeat;");
    if(@!include(VIEWS_TEMPLATE_PATH.trim($_GET['config']).'.php')){
	    echo("<span class=\"warning\" >No configuration view exist for the specified.</span>");
    }
}
?>

</div>
