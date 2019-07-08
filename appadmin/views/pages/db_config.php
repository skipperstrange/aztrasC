<script type="text/javascript">
$(document).ready(function(){

  // return false;
    $('div#dbForm').hide().fadeIn(500);;
    });

</script>
<style>
.fixme{
    margin-bottom:.9em;
}

.fixme label{
    font-weight:bold;
    font-size:1.0em;
}
</style>
<div>
<b>Status:</b> <?php
if($needed == 1){ echo '<span style="color:red;">not configured </span> &nbsp;&nbsp;&nbsp;
<a href="#" onclick="toggleHideDiv(\'id\',\'dbForm\',400); return false;" >configure &raquo;</a>';
}else{
echo '<span style="color:green;">configured</span> &nbsp;&nbsp;&nbsp;
<a href="#" onclick="toggleHideDiv(\'id\',\'dbForm\',400); return false;" >reconfigure &raquo;</a>';
}
?>
<div id="dbForm">
<h4>Database server configuration.</h4>
<form method="POST" action="#">

<div class="fixme">
<label>host:</label>
<br />
<input type="text" placeholder="Database Host" value="<?php if($needed != 1) echo HOST; ?>" name="db_config[host]" required />
</div>

<div class="fixme">
<label>username: </label>
<br />
<input type="text" placeholder="Username"  value="<?php if($needed != 1) echo USERNAME; ?>"  name="db_config[username]" required="required" />
</div>

<div class="fixme">
<label>password: </label>
<br />
<input type="password" placeholder="Password" name="db[password]" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php if(trim(PASSWORD) != ''){ ?><span style="color: #888;">Password is configured</span><?php }else {?><span style="color: #888;">Password is not configured</span><?php }?>
</span>

</div>

<div class="fixme">
<label>Database (Optional): </label>
<br />
<input type="text" placeholder="Database Name" value="<?php if($needed != 1) echo DATABASE; ?>" name="db[database]" />
</div>
 
<span style="">
<input name="checkConnection"  type="checkbox"  />
Test Connection &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input name="createdb"  type="checkbox"  />
Create Database

<br /><br />
<input type="submit" value="Save" name="submitDB" /></td>

<?php
if($needed != 1){
?>
<span style="float: right;">
<a class="button" href="index.php?view=<?php echo urlencode($admin_view);?>&clear=true">Clear Configuration</a>
<a class="button" href="index.php?view=<?php echo urlencode($admin_view);?>&delete=true">Delete Configuration</a>
</span>
<?php
}
?>
&nbsp;&nbsp;<span valign="top" style="font-size: 12px;">
Database configuratuation applies to MySQL, MySQLi
</span>

</form>
</div><!-- end dbForm div -->
</div>
