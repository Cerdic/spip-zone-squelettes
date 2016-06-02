function padd_create_slideshow() {
	jQuery('div#slideshow-box').append('<a class="dir-button dir-button-l" id="jqc-prev" href="#"></a>');
	jQuery('div#slideshow-box').append('<a class="dir-button dir-button-r" id="jqc-next" href="#"></a>');
	jQuery('div#slideshow-box').append('<div id="slideshow-controller"><span id="jqc-pages"></span></div>');
	len = jQuery('div#slideshow-box .item').length;
	jQuery('div#slideshow-box .dir-button-l').css('z-index', len + 2);
	jQuery('div#slideshow-box .dir-button-r').css('z-index', len + 3);
	jQuery('div#slideshow-controller').css('z-index', len + 4);
	jQuery('div#slideshow-box div.list').cycle({
		fx                : 'fade',
		speed             : 1000,
		timeout           : 3000,
		cleartypeNoBg     : true,
		activePagerClass  : 'jqc-active',
		pager             : '#jqc-pages',
		prev              : '#jqc-prev',
		next              : '#jqc-next',
		pause             : true,
		pagerAnchorBuilder: function (index,elem) {
			return '<button class="jqc-button jqc-button-pages" id="jqc-button-' + index + '" value="' + index + '"><span>' + (index+1) + '</span></button>';
		}
 	});
}

function padd_tabs_init() {

}

jQuery(document).ready(function() {

	padd_create_slideshow();

});