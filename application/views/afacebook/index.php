<?php
//print_r($data);

 if($fbdata['fbuser']){
?>
      Your user profile is
      
        <?php print htmlspecialchars(print_r($fbdata['fbuserprofile'], true)) ?>
      
    <?php } else { ?>
      <fb:login-button></fb:login-button>
    <?php } ?>
    