jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch("../images/backgrounds/sign-up-bg.jpg");
    
    $('.animated.sign-up-text').addClass('pulse');
    /*
        Registration form validation
    */
    $('.registration-form input[type="text"], .registration-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.registration-form').on('submit', function(e) {
    	e.preventDefault();
        var error = false;
    	var signupObject = {};
    	$(this).find('.req-field').each(function(){
    		if( $(this).val() == "" ) {
    			$(this).addClass('input-error');
                error = true;
    			return;
    		}
    		else {
    			$(this).removeClass('input-error');
    			signupObject[$(this).attr('id')] = $(this).val();
    		}
    	});
        if(!error){
            $('#signup-btn').button('loading');
            $('body').css('cursor','wait');
            $('#signup-preloader-img').css('display','block');
            $.ajax({
                method: "POST",
                url: "../bin/parser.php",
                dataType: 'text',
                data:{
                    param: '3',
                    firstName : signupObject['form-first-name'],
                    lastName : signupObject['form-last-name'] ? signupObject['form-last-name'] : ' ',
                    email : signupObject['form-email'] ? signupObject['form-email'] : ' ',
                    mobile : signupObject['form-mobile'],
                    aboutY : signupObject['form-about-yourself'] ? signupObject['form-about-yourself'] : ' ',
                }       
            })
            .done(function(data, textStatus, jqXHR ){
                if(data == 'success'){
                    $('.alert.alert-success').css('display','block');
                    setTimeout(function(){ 
                       window.location = '../index.php'; 
                    }, 3000);
                }else {
                     window.location = '../index.php'; 
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){

            })
            .always(function(jqXHR, textStatus, errorThrown){
                $('#signup-btn').button('reset');
                $('body').css('cursor','default');
                $('#signup-preloader-img').css('display','none');
            }); 
        }    	
    });   
});
