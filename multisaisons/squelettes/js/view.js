var jDocument=jQuery(document);

jDocument.ready(function(){

	jQuery('#header').corner("top");
	jQuery('#surcontent').corner("bottom");

	jQuery('#content').corner();
	jQuery('#footer').corner();
	
	jQuery('.boite').corner();
	jQuery('.grande_boite').corner();
	jQuery('ul#minipics li').corner();
	jQuery('.avatar').corner();
	jQuery('.reponse').corner();
	jQuery('.discussion').corner();
	jQuery('.interne').corner();
    jQuery('span.pixlogo').corner();
    
    
    jQuery('#container').corner("15px");
	jQuery('div.interforum').corner("15px");
	jQuery('div.interforumgrand').corner("15px");

	jQuery('ul#deco h4').corner("top");
	jQuery('ul#decobas h4').corner("top");
    jQuery('ul#nav li').corner("top");
	
	jQuery('#cel p').corner("bottom");
	jQuery('#celbas p').corner("bottom");
});