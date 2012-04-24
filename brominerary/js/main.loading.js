
function paddAppendClear() {
	jQuery('.append-clear').append('<div class="clear"></div>');
}

function paddToggle(classname,value) {
	jQuery(classname).focus(function() {
		if (value == jQuery(classname).val()) {
			jQuery(this).val('');
		}
	});
	jQuery(classname).blur(function() {
		if ('' == jQuery(classname).val()) {
			jQuery(this).val(value);
		}
	});
}

function paddSidebarTabsInit() {
	if (!jQuery("#sidebar-tabs").length) {
		return;
	} else {
		jQuery("#sidebar-tabs").tabs({ cookie: { expires: 30 } });
	}
}

jQuery(window).load(function() {
	jQuery('#slideshow').nivoSlider({
		effect: 'sliceUpDown',
		animSpeed: 1000,
		pauseTime: 10000
	});
});

jQuery(document).ready(function() {
	jQuery.noConflict();
	
	jQuery('div#menubar div > ul > li:first').css('background','transparent none');
	jQuery('div#menubar div > ul ul li:last-child a').css('border-bottom','0 none');
	jQuery('div#menubar div > ul').superfish({
		autoArrows: true,
		hoverClass: 'hover',
		speed: 500,
		animation: { opacity: 'show', height: 'show' }
	});

	paddAppendClear();
	
	jQuery('input#s').val('keywords here');
	paddToggle('input#s','keywords here');

	jQuery('div.search form').click(function () {
		jQuery('input#s').focus();
	});
	
	paddSidebarTabsInit();
});
