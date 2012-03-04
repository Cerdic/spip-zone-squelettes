var Debug = {
	debug:false,
	
	log:function(text) {
		if(this.debug) console.log(text);
	}
}

$(document).ready(function(){
	
	/*
	 * debut legendes images
	 */
	var securityTopLeft=0, securityTopRight=0;
	$("div#nav").each(function(){
		securityTopLeft = $(this).offset().top + $(this).height();
		Debug.log("securityTopLeft : " + securityTopLeft);
		return;
	});
	$("div#about").each(function(){
		securityTopRight = $(this).offset().top + $(this).height();
		Debug.log("securityTopRight : " + securityTopRight);
		return;
	});
	
	$("body.article h2 span.spip_documents").each(function(){
		$(this).addClass("nolegendplease");
	});

	$("body.article span.spip_documents").each(function(){
		var isDone = false;

		if(!$(this).hasClass("nolegendplease")) {
			if($(this).hasClass("spip_documents_right") && $(this).offset().top > securityTopRight) {
				Debug.log("this.offset.top : " + $(this).offset().top + " - securityTopRight : " + securityTopRight);
				$(this).append("<span class='legend'>" + $(this).find("img").attr("alt") + "</span>");
				$(this).find("span.legend").css("left", $(this).width() + 20);
				isDone = true;
			} else if(!$(this).hasClass("spip_documents_right") && $(this).offset().top > securityTopLeft) {
				$(this).append("<span class='legend'>" + $(this).find("img").attr("alt") + "</span>");
				isDone = true;
			}
			
			if(isDone) {
				$(this).find("img").attr("alt","");
				$(this).find("img").attr("title","");
			}
		}
	});
	/*
	 * fin legendes images
	 */

	/*
	 * debut gravatars
	 */
	$("body.article div.forum-titre h3").each(function(){
		str = $(this).attr("class");
		Debug.log("str : " + str);
		if(str && str.match(/gravatar/)) {
			$(this).css("background-image","url(http://www.gravatar.com/avatar.php?gravatar_id=" +
					str.substring(9) +
					"&size=48&rating=PG&default=http%3A%2F%2Fwww.nota-bene.org%2Frien.gif)")
		}
	});
	/*
	 * fin gravatars
	 */
	
	/*
	 * debut largeur page
	 */
	setWidth();
	$(window).bind("resize","",setWidth);
	/*
	 * fin largeur page
	 */
	
	/*
	 * debut legende header
	 */
	Debug.log(document.logo_url);
	Debug.log(document.logo_legend);
	if(document.logo_url && document.logo_legend) {
		$("div#header>div").append("<div id='logo_legend'>" +
			"<a href='" + document.logo_url + "' title='" + document.logo_legend + "'>" +
			"<img src='/v5/img/logo_legend.png' alt='" + document.logo_legend + "' />" +
			"</a>" +
			"</div>"
		);
	}
	/*
	 * fin legende header
	 */
	
});

function setWidth() {
	Debug.log("setWidth lancé");
	w = $("body").width();
	Debug.log("w : " + w);
	if(w<900) {
		$("body").addClass("narrow");
	} else {
		$("body").removeClass("narrow");
	}
}
