<?php
function db_connect($nodie=0){
 global $dbh,$DB;
 $dbh=mysql_connect(HOST,USERNAME,PASSWORD);
}
db_connect();
?>
<script type="text/javascript">
//$(document).ready(function(){});
function $(i){return document.getElementById(i)}
function frefresh(){
 var F=document.DF;
 F.method='post';
 F.refresh.value="1";
 F.submit();
}
function trefresh(){
 var F=document.DF;
 F.method='get';
 F.refresh.value="1";
 F.submit();
}
</script>


 <form id="DF" name="DF" method="post" action="">
  <input type="hidden" name="refresh" value="">
<input type="hidden" name="p" value="">

        <b>Select Database:</b>
             <select name="db" onChange="frefresh();">
        <option value='*'> - select/refresh -</option>
        <?php

		$arr = array();
		 if ($_SESSION['sql_sd']){//check cache
			$arr=$_SESSION['sql_sd'];
		 }else{

		   $sql = 'show databases';
			$sth = mysql_query($sql);
			while($row=mysql_fetch_assoc($sth))$arr[]=$row;

		   $_SESSION['sql_sd']=$arr;
		 }

		foreach($arr as $row) {?>
        <option value="<?php echo $row['Database']; ?>" <?php if(!strcmp($_POST['db'],$row['Database']) ) echo 'selected="selected"'; ?>><?php echo $row['Database']; ?></option>
        <?php ;} ?>
        </select>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span >
	Select Table :
        

        <select name="tbs" id="tbs" onChange="frefresh()">
		<option value=''> - select/refresh -</option>
        <?php
		if( isset($_POST['db']) ){
		$arrs = array();

			 mysql_select_db($_POST['db'], $dbh);
		   $sql = 'show tables from `'.$_POST['db'].'`';
			$sth = mysql_query($sql);
			//while($rows=mysql_fetch_row($sth)){ $arrs[]= $rows[0];}
			while ($row = mysql_fetch_row($sth)) { ?>
            <option value="<?php echo $row[0]; ?>" <?php if(!strcmp($_POST['tbs'],$row[0]) ) echo 'selected="selected"'; ?>><?php echo $row[0]; ?></option>
            <?php
			}
		 }
		?>
        </select>
</span>
              <?php
		if( isset($_POST['db']) &&  isset($_POST['tbs']) ){
		$arrs = array();
			$sql = 'SELECT column_name FROM information_schema.columns WHERE TABLE_SCHEMA = \''.$_POST['db'].'\' AND TABLE_NAME = \''.$_POST['tbs'].'\'';
			$sth = mysql_query($sql);
		$arrs1 = array();
			$sql = 'SELECT COLUMN_NAME FROM `information_schema`.`KEY_COLUMN_USAGE`
				WHERE `TABLE_SCHEMA` = \''.$_POST['db'].'\'
				AND
				`TABLE_NAME` =\''.$_POST['tbs'].'\'
				AND `CONSTRAINT_NAME` = \'PRIMARY\'
				OR `CONSTRAINT_NAME` = \'UNIQUE\'
				OR `CONSTRAINT_NAME` = \'INDEX\'';

			  if($strs = @mysql_query($sql)){
			   $primary = mysql_fetch_row($strs);
			   $primary = $primary[0];
			  }

?>
<br /><br />
<style>

table tr:hover{
background: #ddd;
 }

</style>

<table width="620px" border="0">
<tr bgcolor="#b7c2f7">
 <td colspan="20" ><span style="margin-bottom:"><b>Select Columns to Use:</b></span></td>
</tr>

<?php
			while ($row = mysql_fetch_row($sth)) { ?>

<tr bgcolor="#f3f5ff">
        <td>
        <label> <input name="cols[]" type="checkbox" value="<?php echo $row[0]; ?>" checked="checked" /><?php if($row[0] == $primary){echo '<u>'. $row[0].'</u>';}else{echo $row[0]; }  ?></label>

                <select name="field_<?php echo $row[0]; ?>" style="float: right;">
		<option value="checkbox">Checkbox</option>
		<option value="email">Email</option>
                <option value="file">Filetype</option>
                <option value="hidden">Hidden</option>
		<option value="password">Password</option>
		<option value="radiobutton">Radio</option>
		<option value="select">Select</option>
                <option value="text">Text</option>
                <option value="textarea">Text Area</option>

                </select>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        </td>
	<!--<td><input name="field_<?php echo $row[0]; ?>_required" type="checkbox" value=""  /> required</td>-->
</tr>
            <?php
		       }
?>

<tr>
 <td colspan="20"><?php if($_POST['tbs']){ ?>
 <br />
 <input name="validate" type="checkbox" value="" checked="checked" /> <b>Validate forms</b>
 <br />
 <b>Class Name:</b> <input name="class_name" type="text" id="class_name" placeholder="Class Name" value="<?php if($_POST['tbs']) echo $_POST['tbs']; ?>" />

        <?php } ?>
<?php if($primary){
?>
<input name="primary_key" type="hidden"  value="<?php echo $primary; ?>" />
<?php
}else{
?>
<select name="primary">
 <option value="">Choose Primary Key</option>
 <?php
  while ($row = mysql_fetch_row($sth)):
?>
<option value="<?php echo $row[0] ?>"><?php echo $row[0] ?></option>
<?php
endwhile;
?>

</select>
<?php
 }
?>

<select name="exts[ext]">
<option value="">Extension Type</option>
<option value="extends">extends</option>
<option value="impliments">impliments</option>
</select>

<select name="exts[parent]">
<option value="">Choose Parent</option>
<?php
$adFolders = FileSystem::folderStructure(UP_ONE. ADAPTORS_PATH);
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

        &nbsp;&nbsp;
            <input type="submit" name="button" id="button" value="Generate Class" />
        &nbsp;</td>

</tr>

</table>
<?php
}
?>

  </form>

<div class="desc">All names and values should be alphanumeric. No special characters.</div>

<div class="desc"><span class="alert">!</span> Already existing files will not be overwritten. Models will extend mysql_ad adaptor class.</div>
<div class="desc"><span class="alert">!</span> CRUD methods and views will written to files and folders on submission</div>