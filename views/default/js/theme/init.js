define(['require', 'jquery', 'foundation'], function(require, $) {

	$(document).foundation();

	// Make More menu item respond to clicks
	$('.elgg-menu-site li.elgg-more')
			.on('mouseover', function() {
				$(this).addClass('elgg-state-active')
			})
			.on('mouseout', function() {
				$(this).removeClass('elgg-state-active')
			})
			.on('click', function(e) {
				if ($(this).hasClass('elgg-state-active')) {
					$(this).removeClass('elgg-state-active')
				} else {
					$(this).addClass('elgg-state-active')
				}
			});

	return true;

});