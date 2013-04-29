$(document).ready(function (){
	$("#s3sliderContent").cycle();

	$("#s3sliderContent").mouseenter(function (){
		$("#s3sliderContent").cycle('pause');	
	});

	$("#divPrincipSlider").mouseenter(function (){
		$(".arrowslider").fadeIn(400);
		$(".desc").slideDown(400);
	});	
	
	$("#divPrincipSlider").mouseleave(function (){
		$(".arrowslider").fadeOut(400);
		$(".desc").slideUp(400);
	});

	$("#s3sliderContent").mouseleave(function (){
		$("#s3sliderContent").cycle('resume');
	});

	$("#jqc-prev").click(function (){
		$("#s3sliderContent").cycle('prev');
	});

	$("#jqc-next").click(function (){
		$("#s3sliderContent").cycle('next');
	});
	
	jQuery('.menu-liste').superfish({
		autoArrows: false,
		hoverClass: 'hover',
		speed     : 500,
		delay     : 0,
		animation : {
			opacity: 'show',
			height : 'show'
		}
	});

	// Colorer les 3 derniers caractères d'une chaine de caractère
	var i = $("#nom_site_spip a").text().length;
	var text_debut = $("#nom_site_spip a").text().substring(0, i-3); 
	var text_fin = $("#nom_site_spip a").text().substring(i-3, i);
	$("#nom_site_spip a").html(text_debut+'<span class="fin-titre">'+text_fin+'</span>');
	$(".fin-titre").css('color', '#A2A2A2');

})