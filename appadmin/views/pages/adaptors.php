<style>
table tr:hover{
background: #ddd;
 }
 </style>
<?php
$embededADfolders = array();
foreach($adFolders as $folder =>$someadaptor):
$adaptor = (array_pop(explode('/',$folder))).'<p></p>';
array_push($embededADfolders,$adaptor);
endforeach;

?>
<b>Loaded adaptors:</b>
<div style="width:60%;">
<?
$ads = array();
while(!feof($openADfile)) {
			$entry = fgets($openADfile);
			if(trim($entry) != "") {
			 $entry = str_replace('?>','',str_replace('<?','',(str_replace('<?php','',$entry))));
              $entry = explode('\'',$entry);
          //    print_r($entry);
              $entry = $entry[1];
                if(trim($entry) != ''):
                echo "".$entry.", ";
                array_push($ads,trim($entry));
                endif;
			}
		}
?>
</div>
<!-- javascript to hide form -->
<script type="text/javascript">
$(document).ready(function(){

  // return false;
    $('div#ad_edit').hide().fadeIn(700);
    });

</script>

<span style="float: right;"><a href="#" onclick="toggleHideDiv('id','ad_edit');return false;" >Modify</a></span>

<div id="ad_edit" style="margin-bottom: 10px;">
<?
$form = new stpForms;
$form->startForm('','','style,padding-bottom:10px;');
$form->output('
');
?>
<style type="text/css">
ul#gallery li{
    width: 130px;
}
</style>
<?
$form->oTag('ul','id,gallery | style,overflow:auto;');

foreach($adFolders as $folder => $files):
$folderName  = (array_pop(explode('/',$folder)));
if(count($files) != 0):
echo "<li style=\"min-height:100px;\">";
//print_r($adFolders);
if($folderName == 'adaptors'){
    echo '<b><u>Other:</u> </b>';
    echo count($files);
}else{
    echo "<b><u>$folderName: </u></b>
    ";
    echo count($files);
}

$STP_HTML->oTag('p');

foreach ($files as $db):
    $dbname = str_replace('.ad', '', $db);
if(in_array(trim($dbname),$ads)){
    $form->checkbox('', "name,adaptors[$folderName][$dbname]  | checked,true");
}else{
   echo "<input name=\"adaptors[$folderName][$dbname]\" type=\"checkbox\"  />";
}

    $STP_HTML->b($dbname);
    $form->br();
endforeach;
$STP_HTML->cTag('p');
echo "</li>";

endif;
endforeach;


$form->cTag('ul');

$form->submit('Save',' name,dbSetOptions ');

$form->endForm();

$STP_HTML->br();
$STP_HTML->br();
?>
</div>
