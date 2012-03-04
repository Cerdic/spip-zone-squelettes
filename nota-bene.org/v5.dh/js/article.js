
var Loader = {
	/**
	 * addASAP
	 * adds load to the page
	 * tries to add it as soon as the dom has loaded if possible
	 * else adds it to the window.onload stack
	 * inspired by the discussion at http://dean.edwards.name/weblog/2006/06/again/
	 * @param func function to be added
	 */
	addASAP: function(func) {
		ignited=false;
		/* for Mozilla/Opera9 */
		if (document.addEventListener  && !ignited) {
		  document.addEventListener("DOMContentLoaded", func, false);
		  ignited=true;
		}
		
		/* for Internet Explorer */
		/*@cc_on @*/
		/*@if (@_win32)
		  document.write("<script id=__ie_onload defer src=javascript:void(0)><\/script>");
		  var script = document.getElementById("__ie_onload");
		  script.onreadystatechange = function() {
		    if (this.readyState == "complete" && !ignited) {
		      func(); // call the onload handler
		      ignited=true;
		    }
		  };
		/*@end @*/
		
		/* for Safari */
		if (/WebKit/i.test(navigator.userAgent) && !ignited) { // sniff
		  var _timer = setInterval(function() {
		    if (/loaded|complete/.test(document.readyState) && !ignited) {
		      func(); // call the onload handler
		      ignited=true;
		    }
		  }, 10);
		}
		
		if(!ignited) {
			var oldonload = window.onload;
			if (typeof window.onload != 'function') {
				window.onload = func;
			} else {
				window.onload = function(){
					if (oldonload) {
						oldonload();
					}
					func();
				}
			}
			ignited = true;
		}
	},
	
	addOnLoad: function(func) {
		var oldonload = window.onload;
		if (typeof window.onload != 'function') {
			window.onload = func;
		} else {
			window.onload = function(){
				if (oldonload) {
					oldonload();
				}
				func();
			}
		}
	}
}


var Article = {
	
	/**
	 * findGravatars
	 * finds H3's that have a gravatar-* class
	 * creates on the fly a CSS for each
	 */
	findGravatars: function() {
		var h3s = document.getElementsByTagName("h3");
		for(var i=0 ; i<h3s.length ; i++) {
			if(h3s[i].className.match(/gravatar/)) {
				h3s[i].style.backgroundImage = "url(http://www.gravatar.com/avatar.php?gravatar_id=" +
					h3s[i].className.substring(9) +
					"&size=48&rating=PG&default=http%3A%2F%2Fwww.nota-bene.org%2Fv5%2Frien.gif)";
			}
		}
	},
	
	addLegendsToImages: function() {
		var spans = document.getElementById('content').getElementsByTagName('span');
		if(spans.length>0) {
			// we check if we've got enough room to display the funky legend
			var minHeight = Math.max(Article.getTop("nav") + Article.getHeight("nav") , Article.getTop("about") + Article.getHeight("about"));
			for(var i=0; i<spans.length; i++) {
				if(spans[i].className.match('spip_documents')) {
					// we fetch the image
					myimg = spans[i].getElementsByTagName('img')[0];
					myimg.id="dynamiclegend"+i;
					var mytop = Article.getTop(myimg.id);
					//var mytop =0;
					if (mytop > minHeight) {
						// ... then create a new title span, and append it to the spip_documents span
						t = document.createTextNode(myimg.getAttribute('title'));
						s = document.createElement('span');
						s.appendChild(t);
						// we have to set the span's width
						s.className = "legend";
						myimg.parentNode.appendChild(s);
						// screen reader-friendly approach: let's empty the alt and title tags,
						// so that they're not read aloud twice
						myimg.setAttribute('alt', '');
						myimg.setAttribute('title', '');
						if (spans[i].className.match('spip_documents_right')) {
							// right align
							s.style.left = parseInt(s.parentNode.style.width.replace(/px/, '')) + 20 + "px";
						}
					}
				}
			}
		}
	},
	
	getTop: function(id) {
		var obj = document.getElementById(id);
		var curtop = 0;
		if (obj.offsetParent) {
			do {
				curtop += obj.offsetTop;
			}
			while (obj = obj.offsetParent);
		}
		return curtop;
	},
	
	getHeight: function(id) {
		var obj = document.getElementById(id);
		return obj.offsetHeight;
	},

	start: function() {
		if(!document.getElementById || !document.getElementsByTagName || !document.createElement) { return; } /*  clean escape just in case you're using a very rusty browser */
		Loader.addASAP(Article.findGravatars);
		Loader.addOnLoad(Article.addLegendsToImages);
	}
}

Article.start();
