jQuery(document).ready(function($) {
	$('.wdo-tabs-container').find('.tab-pane').first().addClass('active in');
	$('.wdo-tabs-container').find('.nav-tabs li').first().addClass('active');
	var tabs = $('.wdo-tabs-container');
	
	
	tabs.each(function(){
		var thisTabs = $(this);
		thisTabs.children('.tab-content').find('.tab-pane').each(function(index){
			index = index + 1;
			
			var that = $(this),
				link = that.attr('id'),
				// activeNav = that.closest('.tab-content').parent().find('.nav-tabs li').first().addClass('active'),
				navItem = that.closest('.tab-content').parent().find('.nav-tabs li:nth-child('+index+') a'),
				navLink = navItem.attr('href');
				console.log(navLink);

			link = '#'+link;
			if(link.indexOf(navLink) > -1) {
				navItem.attr('href',link);
			}
		});
		$(this).find('.tab-pane').first().addClass('active in');
		$(this).find('.nav-tabs li').first().addClass('active');
	});

	
	
});