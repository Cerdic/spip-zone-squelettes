	


$(document).ready(function() {


	$("#navigation").find(".rubriques, .breves, .syndic, .forums, .divers")
	.css("padding","1px;");

	

	/*
	* Menu dépliant 
	*/
	
	/* gros titres cliquables */
	$("#navigation").find(".menu-titre").wrap("<a href='#'></a>");
	
	$("#navigation ul").hide();

	$("#navigation ul ul").parent()
	.prepend("<span class='toggle toggle_off'></span>");
		
	$("#navigation").find(".on")
	.parent().find("ul:first").show()
	.parent().find(".toggle:first").removeClass('toggle_off').addClass('toggle_on')
	.parent().parent().show();
	
	$("#navigation").find(".menu-titre").toggle(function(){
		$(this).parent().next().show();
	},function(){
		$(this).parent().next().hide();
	});
	

	
	$("#navigation").find(".toggle").toggle(function(){
		$(this).parent().find("ul:first").show();
		$(this).removeClass('toggle_off').addClass('toggle_on');
	},function(){
		$(this).parent().find("ul:first").hide();
		$(this).removeClass('toggle_on').addClass('toggle_off');
	});	
	
	
	/*
	* Onglets
	*/

	$('#onglets_sommaire .onglet:not(:first)').hide();
	$('#onglets_sommaire>ul>li:first').addClass('onglet_on');
	$("#onglets_sommaire>ul>li>a").click(function(){
	
		$(this).parent().addClass('onglet_on_tmp');
		
		$("#onglets_sommaire>ul>.onglet_on").removeClass('onglet_on').find("a").each(function(){	
			id_tab = '#' + $(this).attr('title');
			$(id_tab).hide();
		});
		
		$('.onglet_on_tmp').removeClass('onglet_on_tmp').addClass('onglet_on').find("a").each(function(){
			id_tab = '#' + $(this).attr('title');
			$(id_tab).show();
		});
	});
	

});

