$(document).ready(function (){
	$("#s3sliderContent").cycle();

	$("#s3sliderContent").mouseenter(function (){
		$("#s3sliderContent").cycle('pause');	
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



})