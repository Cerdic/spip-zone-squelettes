
function padd_toggle(classname,value) {
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

function padd_init_tabs() {
	if (!jQuery(".post_category_tab").length) {
		return;
	}
	jQuery(".post_category_tab").tabs({
		fx: {
			opacity: 'toggle'
		}
	});
}


function padd_create_slideshow() {
	console.log("padd_create_slideshow");
	jQuery('div#slideshow-box').append('<a class="dir-button dir-button-l" id="jqc-prev" href="#"></a>');
	jQuery('div#slideshow-box').append('<a class="dir-button dir-button-r" id="jqc-next" href="#"></a>');
	len = jQuery('div#slideshow-box .item').length;
	jQuery('div#slideshow-box .dir-button-l').css('z-index', len + 2);
	jQuery('div#slideshow-box .dir-button-r').css('z-index', len + 3);
	jQuery('div#slideshow-controller').css('z-index', len + 4);
	jQuery('div#slideshow-box div.list').cycle({
		fx                : 'fade',
		speed             : 5000 ,
		timeout           : 1000,
		cleartypeNoBg     : true,
		activePagerClass  : 'jqc-active',
		pager             : '#jqc-pages',
		prev              : '#jqc-prev',
		next              : '#jqc-next',
		pause             : true
 	});
}





jQuery(document).ready(function() {
	jQuery.noConflict();

	jQuery('#menubar .menu-conteneur > ul').superfish({
		autoArrows: true,
		hoverClass: 'hover',
		speed     : 500,
		delay     : 0,
		animation : {
			opacity: 'show',
			height : 'show'
		}
	});

	padd_create_slideshow();
	
	padd_init_tabs();

	

});

