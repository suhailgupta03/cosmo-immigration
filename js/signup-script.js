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
    	var signupObject = {};
    	$(this).find('input[type="text"], textarea').each(function(){
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    			return;
    		}
    		else {
    			$(this).removeClass('input-error');
    			signupObject[$(this).attr('id')] = $(this).val();
    		}
    	});
    	
		$.ajax({
			method: "POST",
			url: "./bin/sign-up.php",
			dataType: 'text',
			data:{
				firstName : signupObject['form-first-name'],
				lastName : signupObject['form-last-name'],
				email : signupObject['form-email'],
				mobile : signupObject['form-mobile'],
				aboutY : signupObject['form-about-yourself'],
			}		
		})
		.done(function(data, textStatus, jqXHR ){
			if(data == 'success'){
				
			}
		})
		.fail(function(jqXHR, textStatus, errorThrown){

		})
		.always(function(jqXHR, textStatus, errorThrown){
		});	
    	
    });
    
    
});