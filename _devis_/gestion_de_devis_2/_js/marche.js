// JavaScript Document
//Fonciton qui permet d'imprimer la page
function imprime() {
if (typeof(window.print) != 'undefined')
 { window.print(); }
}
// Fonction qui permet d'ouvrir des popup
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function SymError()
{
  return true;
}
window.onerror = SymError;

sfHover = function() {
	var sfEls = document.getElementById("nav").getElementsByTagName("li");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
