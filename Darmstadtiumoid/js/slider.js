$(document).ready(function (){
	$("#s3sliderContent").cycle();

	$("#s3slider").mouseenter(function (){
		$("#s3sliderContent").cycle('pause');	
	});
	$("#jqc-prev").mouseenter(function (){
		$("#s3sliderContent").cycle('pause');	
	});
	$("#jqc-next").mouseenter(function (){
		$("#s3sliderContent").cycle('pause');	
	});

	$(".s3sliderImage").each(function(index){
		var n=index+1;
		$(".slidercadre"+n).mouseenter(function (){
			$(".desc"+n).slideDown(400);
		});
		
		$("#s3slider").mouseleave(function (){
			$(".desc"+n).slideUp(400);
		});
	});
		
	$("#divPrincipSlider").mouseenter(function (){
		$(".arrowslider").fadeIn(400);
	});	
	
	$("#divPrincipSlider").mouseleave(function (){
		$(".arrowslider").fadeOut(400);
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
	
	// Effet sur les menus deroulants
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

	// Colorer les 3 derniers caracteres du titre du site
	var i = $("#nom_site_spip a").text().length;
	var text_debut = $("#nom_site_spip a").text().substring(0, i-3); 
	var text_fin = $("#nom_site_spip a").text().substring(i-3, i);
	$("#nom_site_spip a").html(text_debut+'<span class="fin-titre">'+text_fin+'</span>');
	$(".fin-titre").css('color', '#A2A2A2');

})