<?php $adFolders = FileSystem::folderStructure(UP_ONE. ADAPTORS_PATH); ?>
<h2>Models(<?php echo count($Model_files); ?>)</h2>

<div style="width: 100%;">
<?
$loaded_models = array();
/**
while(!feof($openModelfile)) {
			$entry = fgets($openModelfile);
            if(preg_match('/\.Model/',$entry)  ){
			if(trim($entry) != "") {

			 $entry = str_replace('?>','',str_replace('<?','',(str_replace('<?php','',str_replace('include(MODEL_PATH.\'','',str_replace('@','',str_replace('\');','',str_replace('.Model.php','',$entry))))))));
                if(trim($entry) != ''):
                array_push($loaded_models,trim($entry));
                endif;
			}
            }
		}
        */

?>
<b>Loaded Models (<?php echo count($loaded_models);?>):</b><span style="float: right;"> <a class="button" href="index.php?&view=<?php echo $admin_view ?>&clearmodelslist=true">Clear all</a></span>
<br />
<?php
        if(!empty($loaded_models) > 0){
         foreach($loaded_models as $loaded_model){
             if(file_exists('../'.MODEL_PATH.$loaded_model.'.Model.php')){
		echo $loaded_model.', ';
            }
         }
        }
?>
<div class="desc"><span class="alert">!</span> Deleting your models can cause your appliction to function improperly.</div>
<?php

 if(count($loaded_models) > 0){
    echo "<br />Unavailible models<span style=\"font-size:9px;\">(loaded but not found)</span>:<br />";
         foreach($loaded_models as $loaded_model){
             if(!file_exists('../'.MODEL_PATH.$loaded_model.'.Model.php')){
            echo '<span class="desc">'.$loaded_model.' does not exist anymore.</span><br /> ';
            }
         }
        }

?>
</div>


<br />
<b>
Add New Model:
</b>
<form action="#" method="POST" validate>
<table>
<tr>
<td>
Model Name:
</td>
<td>Primary Key</td>
</tr>
<tr>
<td>
<input name="model[name]" required placeholder="Model Name" value="<?php if($ee>0){echo $_POST['model']['name'];} ?>" />

</td>
<td>

<input name="primary_key"  placeholder="Primary Key" value="<?php if($ee>0){echo $_POST['primary_key'];} ?>" />

</td>
<td>
<select name="exts[ext]">
<option value="">Extension Type</option>
<option value="extends">extends</option>
<option value="impliments">impliments</option>
</select>
</td>
<td>
<select name="exts[parent]">
<option value="">Choose Parent</option>
<?php
foreach($adFolders as $folder => $files):
$folderName  = (array_pop(explode('/',$folder)));
echo "<optgroup label=\"$folderName\">";
foreach ($files as $db):
    $dbname = str_replace('.ad', '', $db);
   echo "<option value=\"$dbname\" >$dbname</option>";
$STP_HTML->b($dbname);
endforeach;
echo "</optgroup>";
endforeach;
?>
</select>
</td>
<td>
<b>Options:</b>
<br />
&nbsp;&nbsp;&nbsp;<input name="create_class_anyway" type="checkbox"  />Create class regardless.
<br />
&nbsp;&nbsp;&nbsp;<input name="generate_methods" type="checkbox"  /> Generate Methods
</td>
<tr>
<td><input type="submit" name="m" value="Add Model" /></td>
</tr>
</table>


<br />
<span class="desc">Model names should be alphanumeric. No special characters.
Extensions should have parents.
</span>

</form>

<!-- javascript to hide form -->
<script type="text/javascript">
$(document).ready(function(){

  // return false;
    $('div#models_edit').hide();

    });

</script>

<br />
<span style=""><a href="#" onclick="toggleHideDiv('id','models_edit');return false;" >Modify loaded Models</a></span>

<?php

$form = new stpForms;
$form->oDiv('id,models_edit | style,margin-bottom: 10px;');
$form->h2('Availible Models');

$form->startForm('','','style,padding-bottom:10px;');
$form->output('
');

$STP_HTML->oTag('p');


$STP_HTML->cTag('p');

$form->br();
$form->oDiv().$form->submit('Save',' name,add ').$form->cDiv();

$form->cDiv();

if(!empty($Model_files)):
$colors = array('#f3f5ff','#f4f6ff');
?>

<h2 >Model Files</h2>
<div class="mvc_table">
<table cellpadding="2px" width="100%" border="0">
<tr bgcolor="#b7c2f7">

<td width="30%"><b>Model Name</b></td><td></td>
</tr>
<?php
for($i=0;$i<count($Model_files);$i++):
echo "<tr bgcolor=\"".$colors[($i)%count($colors)]."\">
";

echo "
<td>".str_replace('.Model.php', '', $Model_files[$i])."</td>

<td><!--<a href=\"#\">edit</a> --><a href=\"index.php?view=$admin_view&config=$_GET[config]&deletemodel=".urlencode(str_replace('.Model.php', '', $Model_files[$i]))."\">delete</a></td>
";
echo "</tr>
";
endfor;
?>

</table>
</div>
<?php
endif;
?>
<hr style=" clear:both;" />