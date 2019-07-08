<?php


$STP_HTML->cDiv();
$STP_HTML->comment('end of id content');

$STP_HTML->cDiv();
$STP_HTML->comment('end container div');

$STP_HTML->cDiv();
$STP_HTML->comment('end div');


$STP_HTML->comment('start footer');

$STP_HTML->oTag('footer', 'class,row | style,text-align:center; font-size:.7em;margin-top:.9em;');
$STP_HTML->oDiv('class,col-lg-12');

$STP_HTML->output('Copyright '.strtotime('%y',time()).' skipnet&copy; applications. A skiplog design.');

$STP_HTML->cDiv().$STP_HTML->comment('end of id copy');

$STP_HTML->cTag('footer').$STP_HTML->comment('end of footer');

?>
<script>
  //Uncomment the following code to allow facebook connectivity
  
  /*    window.fbAsyncInit = function() {
        FB.init({
          appId: '<?= FACEBOOK_APPID;?>',
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
      
      FB.ui(
 {
  method: 'feed'
 }
);
*/
    </script>


<?php

$STP_HTML->use_javascript(WEB_URL.'public/js/jquery-1.4.3.min.js');
$STP_HTML->use_javascript(WEB_URL.'public/js/bootstrap.min.js');
$STP_HTML->use_javascript(WEB_URL.'public/js/jqs_fns.js');
$STP_HTML->cTag('body');
$STP_HTML->cTag('html');
