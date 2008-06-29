// S5 v1.1 slides.js -- released into the Public Domain
//
// Please see http://www.meyerweb.com/eric/tools/s5/credits.html for information 
// about all the wonderful and talented contributors to this code!

var undef;
var slideCSS = '';
var snum = 0;
var smax = 1;
var incpos = 0;
var number = undef;
var s5mode = true;
var defaultView = 'slideshow';
var controlVis = 'visible';

var isIE = $.browser.msie;
var isOp = $.browser.opera;
var isGe = $.browser.mozilla || $.browser.safari;

function hasClass(object, className) {
	if (!object.className) return false;
	return (object.className.search('(^|\\s)' + className + '(\\s|$)') != -1);
}

function hasValue(object, value) {
	if (!object) return false;
	return (object.search('(^|\\s)' + value + '(\\s|$)') != -1);
}

function removeClass(object,className) {
	if (!object) return;
	object.className = object.className.replace(new RegExp('(^|\\s)'+className+'(\\s|$)'), RegExp.$1+RegExp.$2);
}

function addClass(object,className) {
	if (!object || hasClass(object, className)) return;
	if (object.className) {
		object.className += ' '+className;
	} else {
		object.className = className;
	}
}

function GetElementsWithClassName(elementName,className) {
	var allElements = document.getElementsByTagName(elementName);
	var elemColl = new Array();
	for (var i = 0; i< allElements.length; i++) {
		if (hasClass(allElements[i], className)) {
			elemColl[elemColl.length] = allElements[i];
		}
	}
	return elemColl;
}

function isParentOrSelf(element, id) {
	if (element == null || element.nodeName=='BODY') return false;
	else if (element.id == id) return true;
	else return isParentOrSelf(element.parentNode, id);
}

function nodeValue(node) {
	var result = "";
	if (node.nodeType == 1) {
		var children = node.childNodes;
		for (var i = 0; i < children.length; ++i) {
			result += nodeValue(children[i]);
		}		
	}
	else if (node.nodeType == 3) {
		result = node.nodeValue;
	}
	return(result);
}

function slideLabel() {
	$('.slide').each(function(i) {
	    $(this).attr('id','slide'+i);
        $('#jumplist').append('<option value="'+i+'">'+i+' : '+$(this).children('h1:eq(0)').text()+'</option>');
        smax = i;
	});
    
    //nombre de slide
	// +1 : ne pas oublier le slide0
    smax += 1;
}

function currentSlide() {
    if (snum == 0) {
        $('#currentSlide').html('');
    } else {
	    $('#currentSlide').html(
            '<span id="csHere">' + snum + '<\/span> ' + 
		    '<span id="csSep">\/<\/span> ' + 
		    '<span id="csTotal">' + (smax-1) + '<\/span>'	
	    );        
    }
}

function go(step) {
	if (document.getElementById('slideProj').disabled || step == 0) return;
	var jl = document.getElementById('jumplist');
	var cid = 'slide' + snum;
	var ce = document.getElementById(cid);
	if (incrementals[snum].length > 0) {
		for (var i = 0; i < incrementals[snum].length; i++) {
			removeClass(incrementals[snum][i], 'current');
			removeClass(incrementals[snum][i], 'incremental');
		}
	}
	if (step != 'j') {
		snum += step;
		lmax = smax - 1;
		if (snum > lmax) snum = lmax;
		if (snum < 0) snum = 0;
	} else
		snum = parseInt(jl.value);
	var nid = 'slide' + snum;
	var ne = document.getElementById(nid);
	if (!ne) {
		ne = document.getElementById('slide0');
		snum = 0;
	}
	if (step < 0) {incpos = incrementals[snum].length} else {incpos = 0;}
	if (incrementals[snum].length > 0 && incpos == 0) {
		for (var i = 0; i < incrementals[snum].length; i++) {
			if (hasClass(incrementals[snum][i], 'current'))
				incpos = i + 1;
			else
				addClass(incrementals[snum][i], 'incremental');
		}
	}
	if (incrementals[snum].length > 0 && incpos > 0)
		addClass(incrementals[snum][incpos - 1], 'current');
	ce.style.visibility = 'hidden';
	ne.style.visibility = 'visible';
	jl.selectedIndex = snum;
	currentSlide();
	number = 0;
}

function goTo(target) {
	if (target >= smax || target == snum) return;
	go(target - snum);
}

function subgo(step) {
	if (step > 0) {
		removeClass(incrementals[snum][incpos - 1],'current');
		removeClass(incrementals[snum][incpos], 'incremental');
		addClass(incrementals[snum][incpos],'current');
		incpos++;
	} else {
		incpos--;
		removeClass(incrementals[snum][incpos],'current');
		addClass(incrementals[snum][incpos], 'incremental');
		addClass(incrementals[snum][incpos - 1],'current');
	}
}

function toggle() {
	var slideColl = GetElementsWithClassName('*','slide');
	var slides = document.getElementById('slideProj');
	var outline = document.getElementById('outlineStyle');
	if (!slides.disabled) {
		slides.disabled = true;
		outline.disabled = false;
		s5mode = false;
		fontSize('1em');
		for (var n = 0; n < smax; n++) {
			var slide = slideColl[n];
			slide.style.visibility = 'visible';
		}
	} else {
		slides.disabled = false;
		outline.disabled = true;
		s5mode = true;
		fontScale();
		for (var n = 0; n < smax; n++) {
			var slide = slideColl[n];
			slide.style.visibility = 'hidden';
		}
		slideColl[snum].style.visibility = 'visible';
	}
}

function showHide(action) {
	var obj = GetElementsWithClassName('*','hideme')[0];
	switch (action) {
	case 's': obj.style.visibility = 'visible'; break;
	case 'h': obj.style.visibility = 'hidden'; break;
	case 'k':
		if (obj.style.visibility != 'visible') {
			obj.style.visibility = 'visible';
		} else {
			obj.style.visibility = 'hidden';
		}
	break;
	}
}

// 'keys' code adapted from MozPoint (http://mozpoint.mozdev.org/)
function keys(key) {
	if (!key) {
		key = event;
		key.which = key.keyCode;
	}
	if (key.which == 84) {
		toggle();
		return;
	}
	if (s5mode) {
		switch (key.which) {
			case 10: // return
			case 13: // enter
				if (window.event && isParentOrSelf(window.event.srcElement, 'controls')) return;
				if (key.target && isParentOrSelf(key.target, 'controls')) return;
				if(number != undef) {
					goTo(number);
					break;
				}
			case 32: // spacebar
			case 34: // page down
			case 39: // rightkey
			case 40: // downkey
				if(number != undef) {
					go(number);
				} else if (!incrementals[snum] || incpos >= incrementals[snum].length) {
					go(1);
				} else {
					subgo(1);
				}
				break;
			case 33: // page up
			case 37: // leftkey
			case 38: // upkey
				if(number != undef) {
					go(-1 * number);
				} else if (!incrementals[snum] || incpos <= 0) {
					go(-1);
				} else {
					subgo(-1);
				}
				break;
			case 36: // home
				goTo(0);
				break;
			case 35: // end
				goTo(smax-1);
				break;
			case 67: // c
				showHide('k');
				break;
		}
		if (key.which < 48 || key.which > 57) {
			number = undef;
		} else {
			if (window.event && isParentOrSelf(window.event.srcElement, 'controls')) return;
			if (key.target && isParentOrSelf(key.target, 'controls')) return;
			number = (((number != undef) ? number : 0) * 10) + (key.which - 48);
		}
	}
	return false;
}

function clicker(e) {
	number = undef;
	var target;
	if (window.event) {
		target = window.event.srcElement;
		e = window.event;
	} else target = e.target;
	if (target.getAttribute('href') != null || hasValue(target.rel, 'external') || isParentOrSelf(target, 'controls') || isParentOrSelf(target,'embed') || isParentOrSelf(target,'object')) return true;
	if (!e.which || e.which == 1) {
		if (!incrementals[snum] || incpos >= incrementals[snum].length) {
			go(1);
		} else {
			subgo(1);
		}
	}
}

function findSlide(hash) {
	var target = null;
	var slides = GetElementsWithClassName('*','slide');
	for (var i = 0; i < slides.length; i++) {
		var targetSlide = slides[i];
		if ( (targetSlide.name && targetSlide.name == hash)
		 || (targetSlide.id && targetSlide.id == hash) ) {
			target = targetSlide;
			break;
		}
	}
	while(target != null && target.nodeName != 'BODY') {
		if (hasClass(target, 'slide')) {
			return parseInt(target.id.slice(5));
		}
		target = target.parentNode;
	}
	return null;
}
//si dans l'url nous avons #slidexx, charger la slide correspondante
function slideJump() {
	if (window.location.hash == null) return;
	var sregex = /^#slide(\d+)$/;
	var matches = sregex.exec(window.location.hash);
	var dest = null;
	if (matches != null) {
		dest = parseInt(matches[1]);
	} else {
		dest = findSlide(window.location.hash.slice(1));
	}
	if (dest != null)
		go(dest - snum);
}

//si url locale #slidexx alors on redirection sur la bonne slide 
function fixLinks() {

    $('a').each(function() {
        var res;
        //extrait l'url slide
        if (res = $(this).attr('href').match(/^#slide([0-9]*)$/i)) {
            $(this).click( function(e) {
                if (document.getElementById('slideProj').disabled) return;
                go(res[1] - snum);
                return false;
            });
        }    
    });
}

//si l'url posséde rel=external, on fait un renvoit extérieur
function externalLinks() {

    $('a[@rel=external]').addClass('external').attr('target','_blank');
}

function createControls() {
	
    $('#controls').html(
         '<form action="#" id="controlForm">' +
	    '<div id="navLinks">' +
	    '<a accesskey="t" id="toggle" href="javascript:toggle();">&#216;<\/a>' +
	    '<a accesskey="z" id="prev" href="javascript:go(-1);">&laquo;<\/a>' +
	    '<a accesskey="x" id="next" href="javascript:go(1);">&raquo;<\/a>' +
	    '<div id="navList"><select id="jumplist" onchange="go(\'j\');"><\/select><\/div>' +
	    '<\/div><\/form>'
    );


	if (controlVis == 'hidden') {
	    objet = '#controlForm';
	    $('#navLinks').addClass('hideme');
	} else {
	    objet = '#navList';	
	   	$('#jumplist').addClass('hideme');
	}
    
    $(objet).mouseover(function() {
        showHide('s');    
    });

    $(objet).mouseout(function() {
        showHide('h');    
    });

}

function fontScale() {  // causes layout problems in FireFox that get fixed if browser's Reload is used; same may be true of other Gecko-based browsers
	if (!s5mode) return false;
	var vScale = 22;  // both yield 32 (after rounding) at 1024x768
	var hScale = 32;  // perhaps should auto-calculate based on theme's declared value?
	if (window.innerHeight) {
		var vSize = window.innerHeight;
		var hSize = window.innerWidth;
	} else if (document.documentElement.clientHeight) {
		var vSize = document.documentElement.clientHeight;
		var hSize = document.documentElement.clientWidth;
	} else if (document.body.clientHeight) {
		var vSize = document.body.clientHeight;
		var hSize = document.body.clientWidth;
	} else {
		var vSize = 700;  // assuming 1024x768, minus chrome and such
		var hSize = 1024; // these do not account for kiosk mode or Opera Show
	}
	var newSize = Math.min(Math.round(vSize/vScale),Math.round(hSize/hScale));
	fontSize(newSize + 'px');
	if (isGe) {  // hack to counter incremental reflow bugs
		var obj = document.getElementsByTagName('body')[0];
		obj.style.display = 'none';
		obj.style.display = 'block';
	}
}

function fontSize(value) {
	if (!(s5ss = document.getElementById('s5ss'))) {
		if (!isIE) {
			document.getElementsByTagName('head')[0].appendChild(s5ss = document.createElement('style'));
			s5ss.setAttribute('media','screen, projection');
			s5ss.setAttribute('id','s5ss');
		} else {
			document.createStyleSheet();
			document.s5ss = document.styleSheets[document.styleSheets.length - 1];
		}
	}
	if (!isIE) {
		while (s5ss.lastChild) s5ss.removeChild(s5ss.lastChild);
		s5ss.appendChild(document.createTextNode('body {font-size: ' + value + ' !important;}'));
	} else {
		document.s5ss.addRule('body','font-size: ' + value + ' !important;');
	}
}

function BrowserFix() {
    
    $('#outlineStyle').attr('disabled',true);
    
	/*
	if (isGe) {
		slides.setAttribute('href','null');   // Gecko fix
		slides.setAttribute('href',slideCSS); // Gecko fix
	}
	*/
	if (isIE && document.styleSheets && document.styleSheets[0]) {
		document.styleSheets[0].addRule('img', 'behavior: url(ui/default/iepngfix.htc)');
		document.styleSheets[0].addRule('div', 'behavior: url(ui/default/iepngfix.htc)');
		document.styleSheets[0].addRule('.slide', 'behavior: url(ui/default/iepngfix.htc)');
	}
}

function getIncrementals(obj) {
	var incrementals = new Array();
	if (!obj) 
		return incrementals;
	var children = obj.childNodes;
	for (var i = 0; i < children.length; i++) {
		var child = children[i];
		if (hasClass(child, 'incremental')) {
			if (child.nodeName == 'OL' || child.nodeName == 'UL') {
				removeClass(child, 'incremental');
				for (var j = 0; j < child.childNodes.length; j++) {
					if (child.childNodes[j].nodeType == 1) {
						addClass(child.childNodes[j], 'incremental');
					}
				}
			} else {
				incrementals[incrementals.length] = child;
				removeClass(child,'incremental');
			}
		}
		if (hasClass(child, 'show-first')) {
			if (child.nodeName == 'OL' || child.nodeName == 'UL') {
				removeClass(child, 'show-first');
				if (child.childNodes[isGe].nodeType == 1) {
					removeClass(child.childNodes[isGe], 'incremental');
				}
			} else {
				incrementals[incrementals.length] = child;
			}
		}
		incrementals = incrementals.concat(getIncrementals(child));
	}
	return incrementals;
}

function createIncrementals() {
	var incrementals = new Array();
	for (var i = 0; i < smax; i++) {
		incrementals[i] = getIncrementals(document.getElementById('slide'+i));
	}
	return incrementals;
}

function defaultCheck() {
    defaultView = $('meta[@name=defaultView]').attr('content');
    controlVis = $('meta[@name=controlVis]').attr('content');
}

// Key trap fix, new function body for trap()
function trap(e) {
	if (!e) {
		e = event;
		e.which = e.keyCode;
	}
	try {
		modifierKey = e.ctrlKey || e.altKey || e.metaKey;
	}
	catch(e) {
		modifierKey = false;
	}
	return modifierKey || e.which == 0;
}

function startup() {
    //charge les configuration meta
	defaultCheck();
	//initialise la barre de navigation
	createControls();
	//initialise la liste des slides
	slideLabel();
	//corrige les liens locaux #slidexx
	fixLinks();
	//corrige les liens extérieurs
	externalLinks();
	//reajuste la taille du texte
	fontScale();

		BrowserFix();
		incrementals = createIncrementals();
		slideJump();
		if (defaultView == 'outline') {
			toggle();
		}
		document.onkeyup = keys;
		document.onkeypress = trap;
		document.onclick = clicker;
}

$('document').ready( function() {
    startup();
});


$('window').resize( function() {
    setTimeout('fontScale()', 50);
});
