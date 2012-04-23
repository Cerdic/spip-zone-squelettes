function padd_create_slideshow() {
	jQuery('div#slideshow-box').append('<div id="slideshow-controller"><span id="jqc-pages"></span></div>');
	jQuery('div#slideshow-box div.list').cycle({
		fx                : 'fade',
		speed             : 1000,
		timeout           : 3000,
		cleartypeNoBg     : true,
		activePagerClass: 'jqc-active',
		pager: '#jqc-pages',
		prev: '#jqc-prev',
		next: '#jqc-next',
		pagerAnchorBuilder: function (index,elem) {
			return '<button class="jqc-button jqc-button-pages" id="jqc-button-' + index + '" value="' + index + '"><span>' + (index+1) + '</span></button>';
		}
 	});
}

function padd_jcarousel_init(carousel) {
// Disable autoscrolling if the user clicks the prev or next button.
	carousel.buttonNext.bind('click', function() {
		carousel.startAuto(0);
	});

	carousel.buttonPrev.bind('click', function() {
		carousel.startAuto(0);
	});

	// Pause autoscrolling if the user moves with the cursor over the clip.
	carousel.clip.hover(
		function() {
			carousel.stopAuto();
		},
		function() {
			carousel.startAuto();
		}
	);
}

jQuery(document).ready(function() {
	jQuery.noConflict();

	padd_create_slideshow();
	
	jQuery('ul#featured-projects').jcarousel({
		auto: 5,
		wrap: 'last',
		initCallback: padd_jcarousel_init
	});
});