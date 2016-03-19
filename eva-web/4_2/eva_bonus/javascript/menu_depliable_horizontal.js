$(document).ready(function(){
	$(" #menu_horizontal ul ").css({display: "none"}); // Opera Fix
	$(" #menu_horizontal li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(400);
	},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
	});
});
