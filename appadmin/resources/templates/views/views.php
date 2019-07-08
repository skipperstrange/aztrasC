<h2>Views(<?php echo count($View_folders);  ?>)</h2>

<span class="desc">View names should be alphanumeric. No special characters.</span>

<div class="desc"><span class="alert">!</span> Deleting your views can cause your appliction to function improperly.</div>
<br />
<b>
Add New View:
</b>
<form action="#" method="POST">

<select name='view[folder]'>
<?php
foreach($View_folders as $controller):
if(isset($_POST['view']['folder'])){
if($controller == $_POST['view']['folder']){
    $form->option($controller,'value,'.$controller);
}else{
?>
 <option value="">Choose Group</option>
<?php
}
}else{
$form->option($controller,'value,'.$controller);
}
endforeach;
?>

</select>
Name:
<input name="view[name]" required placeholder="View Name" value="<?php if($ee>0){echo $_POST['view']['name'];} ?>" />


<span><input type="submit" name="v" value="Add View " /></span>
<br />
</form>

<br/>
<b>
New View Group:
</b>
<form action="#" method="POST">

Group Name:
<input name="folder[name]" required placeholder="Folder Name" value="<?php if($ee>0){echo $_POST['folder']['name'];} ?>" />


<span><input type="submit" name="vf" value="Add Group " /></span>
</form>
<br />
<style>
    .h{

    }
</style>
<?php
$STP_HTML->br();
$STP_HTML->b('View Folders');


$STP_HTML->style("
    .view-folders{
    width:100%;
    list-style:none;
    overflow:auto;
    margin:auto;
    }

    .view-folders .folder{
    width:174px;
    float:left;
    padding:3px;
    border-right:1px dashed #aaa;
    text-align: justify
    }

    .folder ul{
    list-style:none;
    padding-left:10px;
    margin-top:3px;
    }

    .folder ul li{
    width:160px;
    display:block;
    width:100%;
    border-bottom:1px solid #ccc;
    }
    ");


$script = "

<script type=\"text/javascript\">
$(document).ready(function(){

  // return false;
";

if(!empty($View_folders)){

$STP_HTML->oDiv('class,view-folders');
foreach($View_folder_files as $folder => $files){

    foreach($files as $file => $f):
       $files[$file] = str_replace('.php','',$f);
    endforeach;

$STP_HTML->oDiv('class,folder');

$script .= " $('span#$folder').hide();";

    $STP_HTML->oTag('b').$STP_HTML->img('public/css/img/folder.png').$STP_HTML->a($folder, '#',"onClick,toggleHideSpan(id%$folder)").$STP_HTML->cTag('b').
    $STP_HTML->span('('.count($files).')','class,ui-li-count');

    if($folder != $DEFAULT_CONTROLLER || $folder != APP):
        $STP_HTML->output('&raquo;').$STP_HTML->a('delete','index.php?view='.$admin_view.'&config='.$_GET['config'].'&deletefolder='.$folder,'style, text-align:right;');
    endif;

    $STP_HTML->br();
    $STP_HTML->oSpan('id,'.$folder.' | style,clear:both;');


    if(!empty($files)):
    $STP_HTML->oTag('ul');

    foreach($files as $file){
        $STP_HTML->oTag('li').
        $STP_HTML->oTag('b').$STP_HTML->a($file).$STP_HTML->cTag('b').
        $STP_HTML->oSpan('style,text-align:right;float:right;width:100%;').
        $STP_HTML->a('delete','index.php?view='.$admin_view.'&config='.$_GET['config'].'&deleteview='.$file.'&folder='.$folder).
        $STP_HTML->cSpan().
        $STP_HTML->cTag('li');
    }
    $STP_HTML->cTag('ul');
    endif;

    $STP_HTML->cSpan();
$STP_HTML->cDiv();

}
$STP_HTML->cDiv();

$script .= "
    });

</script>
";

echo $script;
}
?>