#CACHE{0*30*24*3600}
#HTTP_HEADER{Content-Type: text/javascript; charset=iso-8859-1}
// Menu accessible dynamique et CSS alternatives, V 2.0 (avec jquery)
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
var jp_blankpic='/#CHEMIN{images/1.gif}';
var jp_onclass='menu_plus';
var jp_offclass='menu_minus';
var jp_picalt='<:pyrat:menu_picalt:>';
var jp_strDeplier='<:pyrat:menu_deplier:>';
var jp_strReplier='<:pyrat:menu_replier:>';
var jp_parentID='menu';
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
		for(i=0;i<jp_alluls.length;i++){
			jp_subul=jp_alluls[i];
			if(jp_subul.parentNode.tagName=='LI'){
				jp_supli=jp_subul.parentNode
				jp_islink=jp_supli.getElementsByTagName('a')[0];
				if(jp_islink){
					jp_addimg = document.createElement('img');
					jp_addimg.src=jp_blankpic;
					jp_addimg.className='node';
					jp_addimg.alt='';
					jp_addimg.onclick=function() {jp_ex(this,null);return false;};
					jp_supli.getElementsByTagName('A')[0].onkeypress=inputKeyHandler;
					jp_supli.getElementsByTagName('A')[0].onfocus=function() {jp_ex(this,0);};
					jp_supli.insertBefore(jp_addimg,jp_supli.firstChild);
				}
				// Do not collapse when there is a strong element in the list.
				jp_highlight=jp_subul.parentNode.getElementsByTagName('strong').length==0?true:false;
				jp_disp=jp_highlight?'none':'block';
				var jp_picaltonoff=jp_highlight?jp_picalt+jp_strDeplier:jp_picalt+jp_strReplier;
				jp_pic_class=jp_highlight?jp_onclass:jp_offclass;
				// End  highlight change
				jp_childs=jp_subul.getElementsByTagName('li').length
				jp_momimg=jp_subul.parentNode.getElementsByTagName('img')[0]
				if(jp_momimg){
					jp_momimg.setAttribute('title',jp_picaltonoff+jp_subul.parentNode.getElementsByTagName('a')[0].text);
					jp_momimg.setAttribute('alt',jp_picaltonoff+jp_subul.parentNode.getElementsByTagName('a')[0].text);
					jp_momimg.className=jp_pic_class;
					jp_subul.style.display=jp_disp;
				}
			}
		}
	}
}

// Collapse and Expand node.
function jp_ex(jp_n,jp_event){
	if(jp_canDOM){
		jp_u=jp_n.parentNode.getElementsByTagName("ul")[0];
		if (!jp_u) jp_u=jp_n.parentNode.parentNode.getElementsByTagName("ul")[0];;
		if(jp_u){
			if (((jp_u.style.display=='none'||jp_u.style.display=='')&&(jp_event==0||jp_event==43||jp_event==null))||((jp_u.style.display=='block')&&(jp_event==45||jp_event==null))) {
				jp_u.style.display=jp_u.style.display=='none'||jp_u.style.display==''?'block':'none';
				jp_img=jp_u.parentNode.getElementsByTagName('img')[0];
				jp_img.className=jp_img.className.indexOf(jp_offclass)!=-1?jp_onclass:jp_offclass;
				var jp_strAlt=jp_img.getAttribute('title');
				if (jp_img.className.indexOf(jp_offclass)!=-1) {
					var jp_re = new RegExp (jp_strDeplier, 'gi');
					var jp_strAltNew = jp_strAlt.replace(jp_re,jp_strReplier);
				}else{
					var jp_re = new RegExp (jp_strReplier, 'gi');
					var jp_strAltNew = jp_strAlt.replace(jp_re,jp_strDeplier);
				}
				jp_img.setAttribute('title',jp_strAltNew);
				jp_img.setAttribute('alt',jp_strAltNew);
				adjustLayout();
				return true;
			} else {
				return false;
			}
		}
	}			
}
function inputKeyHandler(ev) {
	ev = ev || event;
	if (jp_ex(ev.target || ev.srcElement,ev.keyCode || ev.which)) {
		ev.cancelBubble= true;
		if (ev.stopPropagation) ev.stopPropagation();
	}
}

function adjustLayout() {
	var h=0;
	$("div.equilibre").height("auto");
	var lastheight = -1;
	var stacked = 0;
	$("div.stackable").each(function(){ if ((lastheight!=0) && (lastheight!=this.offsetTop) && (lastheight!=-1)) {stacked=-1} ; lastheight=this.offsetTop; });
	if (stacked) {
		var hstacked = 0;
		$("div.stackable").each(function(){ hstacked+=this.offsetHeight; });
		var hnotstackable = 0;
		hnotstackable = $("div.notstackable")[0].offsetHeight;
		if (hnotstackable>hstacked) {
			$("div.laststackable").css({'height': hnotstackable + parseInt($("div.laststackable")[0].offsetHeight) - hstacked+'px'});
		} else {
			$("div.notstackablet").css({'height': hstacked+'px'});
		}
	} else {
	$("div.equilibre").each(function(){ h=Math.max(h,this.offsetHeight); }).css({'height': h+'px'});
}
}

$(document).ready(function() {
	jp_expinit();
	adjustLayout();
	$("body").resize(
		function () {
		adjustLayout();
		}
	);
	$("div#footer").corner("bottom 10px", "#53B0DE");
});