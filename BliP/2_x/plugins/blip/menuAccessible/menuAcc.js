// Menu accessible dynamique et CSS alternatives, V 1.0
//
// Copyright (c) 2004 Jacques PYRAT
// http://www.pyrat.net/
//
// Licensed under the LGPL license
// http://www.gnu.org/copyleft/lesser.html
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************
//
// Presets
var jp_blankpic='menuAccessible/0.gif';
var jp_onpic='menuAccessible/plus.gif';
var jp_offpic='menuAccessible/minus.gif';
var jp_picalt='Cliquer pour ';
var jp_strDeplier='déplier : ';
var jp_strReplier='replier : ';
var jp_parentID='menu'; // identifiant du menu. Si vide, toutes les listes de lien de la page sont traitées
// Checking for DOM compatibility	
if (document.getElementById && document.createTextNode && document.createElement){jp_canDOM=true}

function jp_expinit(){
	if (jp_canDOM){
		if(jp_parentID && document.getElementById(jp_parentID)){
			jp_alluls=document.getElementById(jp_parentID).getElementsByTagName('UL');
			jp_alllis=document.getElementById(jp_parentID).getElementsByTagName('LI');
		}else{
			jp_alluls=document.getElementsByTagName('UL');
			jp_alllis=document.getElementsByTagName('LI');
		}
		for(i=0;i<jp_alllis.length;i++){
			jp_islink=jp_alllis[i].getElementsByTagName('A')[0];
			if(jp_islink){
				jp_addimg = document.createElement('img');
				jp_addimg.src=jp_blankpic;
				jp_addimg.className='node';
				jp_addimg.alt='';
				jp_addimg.setAttribute('height','9');
				jp_addimg.setAttribute('width','9');
				jp_cola = document.createElement('a');
				jp_cola.setAttribute('href','#');
				jp_cola.className='node';
				jp_cola.onclick=function() {jp_ex(this);return false;};
				jp_cola.onkeypress=function() {jp_ex(this);return false;};
				jp_cola.appendChild(jp_addimg);
				jp_alllis[i].insertBefore(jp_cola,jp_alllis[i].firstChild);
			}
		}

		for(i=0;i<jp_alluls.length;i++){
			jp_subul=jp_alluls[i];
			if(jp_subul.parentNode.tagName=='LI'){
				// Do not collapse when there is a strong element in the list.
				jp_highlight=jp_subul.parentNode.getElementsByTagName('strong').length==0?true:false;
				jp_disp=jp_highlight?'none':'block';
				var jp_picaltonoff=jp_highlight?jp_picalt+jp_strDeplier:jp_picalt+jp_strReplier;
				jp_pic=jp_highlight?jp_onpic:jp_offpic;
				// End  highlight change
				jp_childs=jp_subul.getElementsByTagName('LI').length
				jp_mom=jp_subul.parentNode.getElementsByTagName('A')[0]
				if(jp_mom){
					jp_momimg=jp_mom.childNodes[0];
					jp_momimg.setAttribute('title',jp_picaltonoff+jp_subul.parentNode.getElementsByTagName('A')[1].innerHTML);
					jp_momimg.src=jp_pic;
					jp_subul.style.display=jp_disp;
				}
			}
		}

		// Suppresion des images qui ne sont pas des plus ou moins
		for(i=0;i<jp_alllis.length;i++){
			jp_mom=jp_alllis[i].getElementsByTagName('A')[0];
			if(jp_mom){
				jp_momimg=jp_mom.childNodes[0];
				if (jp_momimg.src.indexOf(jp_blankpic)!=-1) {
					// remove link and image
					jp_mom.parentNode.removeChild(jp_mom);
				}					
			}
		}
	}
}

// Collapse and Expand node.
function jp_ex(jp_n){
	if(jp_canDOM){
		jp_u=jp_n.parentNode.getElementsByTagName("ul")[0];
		if(jp_u){
			jp_u.style.display=jp_u.style.display=='none'||jp_u.style.display==''?'block':'none';
			jp_img=jp_n.getElementsByTagName('img')[0];
			jp_img.src=jp_img.src.indexOf(jp_offpic)!=-1?jp_onpic:jp_offpic;
			var jp_strAlt=jp_img.getAttribute('title');
			if (jp_img.src.indexOf(jp_offpic)!=-1) {
				var jp_re = new RegExp (jp_strDeplier, 'gi');
				var jp_strAltNew = jp_strAlt.replace(jp_re,jp_strReplier);
			}else{
				var jp_re = new RegExp (jp_strReplier, 'gi');
				var jp_strAltNew = jp_strAlt.replace(jp_re,jp_strDeplier);
			}
			jp_img.setAttribute('title',jp_strAltNew);
			adjustLayout();
		}
	}			
}
	
function makeCookie(Name,Value,Expiry,Path,Domain,Secure){
  if (Expiry != null) {
    var datenow = new Date();
    datenow.setTime(datenow.getTime() + Math.round(86400000*Expiry));
    Expiry = datenow.toGMTString();
  }

  Expiry = (Expiry != null) ? '; expires='+Expiry : '';
  Path = (Path != null)?'; path='+Path:'';
  Domain = (Domain != null) ? '; domain='+Domain : '';
  Secure = (Secure != null) ? '; secure' : '';

  document.cookie = Name + '=' + escape(Value) + Expiry + Path + Domain + Secure;
}

function readCookie(Name) {
  var cookies = document.cookie;
  if (cookies.indexOf(Name + '=') == -1) return null;
  var start = cookies.indexOf(Name + '=') + (Name.length + 1);
  var finish = cookies.substring(start,cookies.length);
  finish = (finish.indexOf(';') == -1) ? cookies.length : start + finish.indexOf(';');
  return unescape(cookies.substring(start,finish));
}

function setActiveStyleSheet(pTitle) {
  var vLoop, vLink;
  for(vLoop=0; (vLink = document.getElementsByTagName("link")[vLoop]); vLoop++) {
    if(vLink.getAttribute("rel").indexOf("style") != -1 && vLink.getAttribute("title")) {
      vLink.disabled = true;
      if(vLink.getAttribute("title") == pTitle) vLink.disabled = false;
    }
  }
}

function selectStyle (vCookieName, vSelection) {
  //WRITE COOKIE
  makeCookie(vCookieName, vSelection, 90, '/');
  //ACTIVE SELECTED ALTERNAT STYLE SHEET
  setActiveStyleSheet(vSelection);
  adjustLayout();
}

if (document.cookie.indexOf('style=')!=-1) {
  css = readCookie('style');
  //ACTIVATE SELECTED STYLE SHEET
  setActiveStyleSheet(css)
}

function adjustLayout()
{
  // Get natural heights
  if (document.getElementById('content')) {
  	document.getElementById('content').style.height="auto";
  	var cHeight = document.getElementById('content').offsetHeight;
  }
  if (document.getElementById('left')) {
  	document.getElementById('left').style.height="auto";
  	var lHeight = document.getElementById('left').offsetHeight;
  }
  if (document.getElementById('right')) {
  	document.getElementById('right').style.height="auto";
  	var rHeight = document.getElementById('right').offsetHeight;
  }

  // Find the maximum height
  var maxHeight = Math.max(cHeight, Math.max(lHeight, rHeight))+'px';

  // Assign maximum height to all columns
  if (document.getElementById('content')) {
  	document.getElementById('content').style.height=maxHeight;
  }
  if (document.getElementById('left')) {
  	document.getElementById('left').style.height=maxHeight;
  }
  if (document.getElementById('right')) {
  	document.getElementById('right').style.height=maxHeight;
  }
  if (document.getElementById('main')) {
  	document.getElementById('main').style.height=maxHeight;
  }
}
