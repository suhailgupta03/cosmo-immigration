/**
 * @author Suhail
 */


$(function(){
	setTitle(window.location.pathname);
	bindServiceLinks();
	$('.brand-banner h1').addClass('animated pulse');
	$('.brand-banner h3').addClass('animated pulse');
	$(window).on('scroll',function(){
		if(document.body.scrollTop > 0)
			$('.scrollToTop').css('display','block');
		else
			$('.scrollToTop').css('display','none');
		
		isScrolledIntoView();
		if( ($(window).scrollTop() + $(window).height()) > $(document).height()-50 ) {
			// No more scroll!
			$('.call-schedule-alert').addClass('animated fadeOutRight');
		}else {
			$('.call-schedule-alert').removeClass('fadeOutRight').addClass('fadeInRight');
		}
	});
	
	// Load jssocials.min.js  (async implementation)
	$.getScript("js/jssocials.min.js",function(data,textStatus,jqxhr) {
		$("#share").jsSocials({
		    url : "http://www.cosmoimmigration.com",
		    text : "Your Future. Our Advice #CosmoImmigration",
            shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest"]
        });
	});
	
	$(".mini-carousel > .carousel, .right-pane > .carousel").swiperight(function() {
		$(this).carousel('prev');
	});
	
	$(".mini-carousel > .carousel, .right-pane > .carousel").swipeleft(function() {  
		$(this).carousel('next');
	});	
});

/**
 * Sets the title for a webpage
 */
var setTitle = function(location) {
	var titleSet = false;
	if(location){
		var params = location.split('/');
		var pageName = params[params.length - 1];
		var title;
		menu = new Menu();
		switch(pageName){
			case homePage:
				title = homeTitle;
				break;
			case aboutPage:
				title = aboutTitle;
				menu.setActiveItem('.about-mi');
				break;
			case servicePage:
				title = servicesTitle;
				menu.setActiveItem('.services-mi');
				break;
			case contactPage:
				title = contactTitle;
				menu.setActiveItem('.contact-mi');
				break;
			case faqPage:
				title = faqTitle;
				menu.setActiveItem('.more-mi');
				break;
			case notFoundPage:
				title = notFoundTitle;
				menu.setActiveItem('.more-mi');
				break;
			case scholarshipPage:
				title = scholarshipTitle;
				menu.setActiveItem('.more-mi');
				break;
			case countriesPage:
				title = countriesTitle;
				menu.setActiveItem('.more-mi');
				break;
			default:
				title = siteName;
			break;
		}
		document.title = title;
		titleSet = true;
	}
	return titleSet;
};

$('.number-only').keydown(function(){
	
});
/**
 * Menu Class
 * Defines all menu related functionalities
 */
var Menu = function(){};
Menu.prototype.setActiveItem = function($selectorClass) {
	$($selectorClass).addClass('active');
}

var bindServiceLinks	=	function(){
	
	$('.service_link').each(function(){
		$(this).on('click',function(event){
			var linkItem	=	$(this).attr('href');
			$('body').animate({'scrollTop':$(linkItem)[0].offsetTop - 30},750);
			event.preventDefault();
		});
	});
	
	$('.scrollToTop').on('click',function(){
		$('body').animate({'scrollTop':0},750);
	});
};

var isScrolledIntoView = function() {
	$('.first-view-animate').each(function() {
		if(!$(this).hasClass('animated pulse')) {
			var docViewTop = $(window).scrollTop();
			var docViewBottom = docViewTop + $(window).height();
			var elementTop = $(this).offset().top;
			var elementBottom = elementTop + $(this).height();
			if( (elementBottom <= docViewBottom) && (elementTop >= docViewTop) ) {
				$(this).addClass('animated pulse');
			}
		}
	});
};

$('#schedule-button').click(function(event) {
	var error = false;
	$('#call-schedule-form input').parent().removeClass('has-error');
	$('#call-schedule-form input').each(function(){
		if(!$(this).val()) 
			error = true;
		if( ($(this).attr('dname') == 'Phone Number') && ($(this).val().length != 10) )
			error = true;
		
		if(error){
			$(this).parent().addClass('has-error');
			return false;
		}
	});
	if(!error) {
		$(this).button('loading');
		// Send an ajax to store in the database
		var name = $('#sc-name').val();
		var phone = $('#sc-phone').val();
		var query = $('#sc-query').val();
		$('#sc-status').empty();
		$.ajax({
			method: "POST",
			url: "./bin/parser.php",
			dataType: 'html',
			data:{
				param: '2',
				fullName: name,
				phoneNumber: phone,
				queryRegarding: query
			},
			statusCode:{
				404: function() {
					alert('Unable to locate post end point');
				}
			}		
		})
		.done(function(data, textStatus, jqXHR ){			
			$('#sc-status').append("Alright! We'll call you soon.").addClass('bg-success text-center').css('display','block');
		})
		.fail(function(jqXHR, textStatus, errorThrown){
			$('#sc-status').append("Something failed! Please check your connection.").addClass('bg-error text-center').css('display','block');
		})
		.always(function(jqXHR, textStatus, errorThrown){
			$('#schedule-button').button('reset');
		});
	}
});
