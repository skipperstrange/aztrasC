/**
*Function that uses jquery to toggle hide and unhide a div
*@params identifer - tells if its an id or class
*@params attribute - the attribute annoted to the styler e.g. id="attribute"
*@params timing - time for toggle duaration by default is 500 milliseconds.
*@author skipper 
*/
function toggleHideDiv(identifier,attribute,timing){
    var target;
    var time;

//check if timing is set.
    if(!timing){//if timing not set.
    //setting default time value
    time = 500;
    }
    else{
    //else initialize timing
    time = timing;
    }        
    
    if(identifier == 'id'){
    target = 'div#'+attribute;
    }
    
    if(identifier == 'class'){
    target = 'div.'+attribute;
    }
    
    $(function(){
    $(target).slideToggle(time);
    });
            
    
}


function slideUpDiv(identifier,attribute,timing){
    var target;
    var time;

//check if timing is set.
    if(!timing){//if timing not set.
    //setting default time value
    time = 500;
    }
    else{
    //else initialize timing
    time = timing;
    }        
    
    if(identifier == 'id'){
    target = 'div#'+attribute;
    }
    
    if(identifier == 'class'){
    target = 'div.'+attribute;
    }
    
    $(function(){
    $(target).slideUp(time);
    });
    
}


function slideDownDiv(identifier,attribute,timing){
    var target;
    var time;

//check if timing is set.
    if(!timing){//if timing not set.
    //setting default time value
    time = 500;
    }
    else{
    //else initialize timing
    time = timing;
    }        
    
    if(identifier == 'id'){
    target = 'div#'+attribute;
    }
    
    if(identifier == 'class'){
    target = 'div.'+attribute;
    }
    
    $(function(){
    $(target).slideDown(time);
    });
	return true;
    
}



/**
*Function that uses jquery to toggle hide and unhide a span
*@params identifer - tels if its an id or class
*@params attribute - the attribute annoted to the styler e.g. id="attribute"
*@params timing - time for toggle duaration by default is 500 milliseconds. 
*/
function toggleHideSpan(identifier,attribute,timing){
    var target;
    var time;

//check if timing is set.
    if(!timing){//if timing not set.
    //setting default time value
    time = 500;
    }
    else{
    //else initialize timing
    time = timing;
    }        
    
    if(identifier == 'id'){
    target = 'span#'+attribute;
    }
    
    if(identifier == 'class'){
    target = 'span.'+attribute;
    }
    
    $(function(){
    $(target).slideToggle(time);
    });
        
}


$(function(){

$('span.warning').hide().slideDown(300);
$('<span class="exit">X</span>').appendTo('span.warning');

$('span.exit').click(function() {
$(this).parent('span.warning').slideUp('fast');
	});
});

$(function(){

$('span.notice').hide().slideDown(300);
$('<span class="exit">X</span>').appendTo('span.notice');

$('span.exit').click(function() {
$(this).parent('span.notice').slideUp('fast');
	});
});


function fadeInDiv(identifier,attribute,timing){
    var target;
    var time;

//check if timing is set.
    if(!timing){//if timing not set.
    //setting default time value
    time = 500;
    }
    else{
    //else initialize timing
    time = timing;
    }        
    
    if(identifier == 'id'){
    target = 'div#'+attribute;
    }
    
    if(identifier == 'class'){
    target = 'div.'+attribute;
    }
    
    $(function(){
    $(target).fadeIn(time);
    });
    
}

function fadeOutDiv(identifier,attribute,timing){
    var target;
    var time;

//check if timing is set.
    if(!timing){//if timing not set.
    //setting default time value
    time = 500;
    }
    else{
    //else initialize timing
    time = timing;
    }        
    
    if(identifier == 'id'){
    target = 'div#'+attribute;
    }
    
    if(identifier == 'class'){
    target = 'div.'+attribute;
    }
    
    $(function(){
    $(target).fadeOut(time);
    });
    
}
