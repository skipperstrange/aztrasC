<?php


#
#ScoopMinimal Class.
#

#doc
    #    name:    flipmg
    #    scope:   Public


class aztrasC extends aztrasController{
    
    
    public function __construct() {
        parent::__construct(get_class($this));

       
    }
    
     function index(){    
	 
        $this->load->view('index');
        
    }
	
	
	function setup(){    
	 
        $this->load->view('setup');
        
    }
    
    
}