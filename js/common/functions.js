/**
 * @author Suhail
 */

$(function(){
	setTitle(window.location.pathname);	
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