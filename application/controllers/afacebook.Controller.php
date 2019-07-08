<?php

#
#ScoopMinimal 
#doc
#    name:    afacebook
#    scope:   Public

class afacebook extends aztrasController {

    var $facebook;
    var $fbData;
    
    /**
     * $fbData keys
     * fbuser
     * fbuserprofile=   array of facebook user 
     * fbuserstat   =   userstatus of fb user
     * fberror      =   facebook error
     * 
     */

    public function __construct() {
        
        parent::__construct(get_class($this));
        
        $this->fbData['fbdata'] = array('fbuser'=>null,
               'fbuserprofile'  =>  null,
               'fbuserstat'     =>  'logged_out',               
               'fberror'        =>  null,
               );
        
        $this->facebook = new Facebook(array(
            'appId' => FACEBOOK_APPID,
            'secret' => FACEBOOK_SECRET,
        ));
        
        // See if there is a user from a cookie
        $this->fbData['fbdata']['fbuser'] = $this->facebook->getUser();
        if ($this->fbData['fbdata']['fbuser']) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
               
                $this->fbData['fbdata']['fbuserstat'] = 'logged_in';
            } catch (FacebookApiException $e) {
                // echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
                $this->fbData['fbdata']['fbuser'] = null;
            }
        } 
        
        
        
    }

    function index() {
        global $ALERTS;             
       
       if($this->fbData['fbdata']['fbuser'] != null){
      // $pagefeed =   $this->fbData['fbdata']['fbuserprofile'] = $this->facebook->api('/me');
        $pagefeed = $this->facebook->api("/" . $this->fbData['fbdata']['fbuserprofile']['id'] . "/posts");
    }else{
        
    }
        $this->load->view('index', $this->fbData);
        
    }


}
