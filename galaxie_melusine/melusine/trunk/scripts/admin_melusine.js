// Fonctions JS pour gérer l'adminsitration de Mélusine

$(window).load(function(){
	$('a.ajout_module, a.uniformiser_bloc').mediabox({
		transition:'elastic',
		speed:500,
		width:"500px",
		height:"90%",
		iframe:true,
		opacity:0.6,
		onComplete:function(){
			// Si on a des choses à charger
		},
		onClosed:function(){
			$('body').fadeTo('slow',0.2);
			window.location.reload();
		}
	});
});