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