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

var Services = function(){}
Services.prototype.flipPanel = function(){

}

$('.service-link').click(function(event) {
	event.preventDefault();
	var element = $(event.target);
	var linkClicked = element.attr('panel-type');
	var content;
	switch(linkClicked) {
		case 'career':
			content = 'Career Info';
			break;
		default:
			break;
	}

	if(content){
		var flippedPanel ='<div class="panel-heading">'+
			                        '<span class="fa-stack fa-5x">'+
			                              '<i class="fa fa-circle fa-stack-2x text-primary"></i>'+
			                              '<i class="fa fa-tree fa-stack-1x fa-inverse"></i>'+
			                        '</span>'+
                   			'</div>'+
				            '<div class="panel-body">'+
				                        '<h4>Career Counselling</h4>'+
				                        '<p>' + content + '</p>'+
				                        '<a href="#" class="btn btn-primary service-link">Learn More</a>'+
				            '</div>';
	}

	$(element).closest('.service-panel').addClass('animated flipOutY');
	$(element).closest('.service-panel').css('display','none');
	$('#career-services').html(flippedPanel);
	$('#career-services').parent().css('display','block');

});