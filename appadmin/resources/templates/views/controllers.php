<h2>Controllers(<?php echo count($Controller_files);  ?>)</h2>
<div class="desc"><span class="alert">!</span> Deleting your controllers can cause your appliction to function improperly.</div>

<br/>
<b>
Add New Controller:
</b>
<form action="#" method="POST">

Controller Name:
<input name="controller[name]" required placeholder="Controller Name" value="<?php if($ee>0){echo $_POST['controller']['name'];} ?>" />


<span><input type="submit" name="c" value="Add Controller" /></span>
<br />
<span class="desc">Controller names should be alphanumeric. No special characters.</span>

</form>


<?php

if(!empty($Controller_files)):
$colors = array('#f3f5ff','#f4f6ff');
?>
<h2 >Controller Files</h2>
<div class="mvc_table">
<table cellpadding="2px" width="100%" border="0">
<tr bgcolor="#b7c2f7">

<td width="30%"><b>Controller Name</b></td><td></td>
</tr>
<?php
for($i=0;$i<count($Controller_files);$i++):
echo "<tr bgcolor=\"".$colors[($i)%count($colors)]."\">
";

echo "
<td>".str_replace('.Controller.php', '', $Controller_files[$i])."</td>

<td><!--<a href=\"#\">edit</a> --><a href=\"index.php?view=$admin_view&config=controllers&deletecontroller=".urlencode(str_replace('.Controller.php', '', $Controller_files[$i]))."\">delete</a></td>
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