/*
	(c) Paul Sowden
	http://www.alistapart.com/articles/alternate/
	http://www.alistapart.com/d/alternate/styleswitcher.js
*/

function setActiveStyleSheet(title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  createCookie("sedna_style", title, 365);
}

function getActiveStyleSheet() {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title") && !a.disabled) return a.getAttribute("title");
  }
  return null;
}

function getPreferredStyleSheet() {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1
       && a.getAttribute("rel").indexOf("alt") == -1
       && a.getAttribute("title")
       ) return a.getAttribute("title");
  }
  return null;
}

function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

window.onload = function(e) {
  var cookie = readCookie("sedna_style");
  var title = cookie ? cookie : getPreferredStyleSheet();
  setActiveStyleSheet(title);
}

window.onunload = function(e) {
  var title = getActiveStyleSheet();
  createCookie("sedna_style", title, 365);
}


var cookie = readCookie("sedna_style");
var title = cookie ? cookie : 'masquer'; // getPreferredStyleSheet(); ne fonctionne pas sur sedna.html, comprends pas...
setActiveStyleSheet(title);


/*
 * Autres fonctions pour Sedna
 */

/* une fonction pour modifier la couleur des intertitres du meme site */
function highlight_site(id) {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("h2")[i]); i++) {
    a.style.background = 'transparent url(sedna.gif)';
  }
  for(i=0; (a = document.getElementsByName(id)[i]); i++) {
    a.style.background = '#004080';
  }
}

/* gerer le cookie des articles lus */
/* attention on ne doit pas depasser 3ko */
function jai_lu(id) {
  var cookie = readCookie("sedna_lu");
  cookie = cookie ? (cookie+','+id) : (''+id);
  cookie = cookie.substring(-3000);
  createCookie("sedna_lu", cookie, 365);
  a = document.getElementById('news'+id);
  a.className='linkvu'; /* ce lien change de style */
}

