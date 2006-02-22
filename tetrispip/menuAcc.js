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
/*
<ul>
 <li>
   <ul>
	<li class="nonode"><a href="#">xxxx</a></li>
	<li class="nonode"><a href="#">xxxx</a></li>
	<li class="nonode"><a href="#">xxxx</a></li>
   </ul>
  </li>
</ul>
 
<script src="menuAcc.js" type="text/javascript"></script>
<script type="text/javascript">
window.onload = function()
{
  jp_expinit(); // Doit être placé *après* le menu concerné!!!
}
</script>

*/

//
// Presets
var jp_blankpic='trans.gif';
var jp_onpic='plus.gif';
var jp_offpic='moins.gif';
var jp_picalt='Cliquer pour ';
var jp_strDeplier='Expand';
var jp_strReplier='Collapse';
var jp_parentID='node'; // identifiant du menu. Si vide, toutes les listes de lien de la page sont traitées
// Checking for DOM compatibility	
if (document.getElementById && document.createTextNode && document.createElement){jp_canDOM=true}

function jp_expinit(){
	if (jp_canDOM){
		if(jp_parentID && document.getElementById(jp_parentID)){
			jp_alluls=document.getElementById(jp_parentID).getElementsByTagName('ul');
			jp_alllis=document.getElementById(jp_parentID).getElementsByTagName('li');
		}else{
			jp_alluls=document.getElementsByTagName('ul');
			jp_alllis=document.getElementsByTagName('li');
		}
		for(i=0;i<jp_alllis.length;i++){
			jp_islink=jp_alllis[i].getElementsByTagName('a')[0];
			if(jp_islink && (jp_alllis[i].className!='nonode')){
				jp_addimg = document.createElement('img');
				jp_addimg.src=jp_blankpic;
				jp_addimg.className='node';
				jp_addimg.alt=' ';
				jp_addimg.border='0';
				jp_addimg.width='10';
				jp_addimg.height='10';
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
			if((jp_subul.parentNode.tagName=='LI')&&(jp_subul.parentNode.className!='nonode')){
				// Do not collapse when there is a strong element in the list.
				jp_highlight=jp_subul.parentNode.getElementsByTagName('strong').length==0?true:false;
				jp_disp=jp_highlight?'none':'block';
				var jp_picaltonoff=jp_highlight?jp_picalt+jp_strDeplier:jp_picalt+jp_strReplier;
				jp_pic=jp_highlight?jp_onpic:jp_offpic;
				// End  highlight change
				jp_childs=jp_subul.getElementsByTagName('li').length
				jp_mom=jp_subul.parentNode.getElementsByTagName('a')[0]
				if(jp_mom){
					jp_momimg=jp_mom.childNodes[0];
					jp_momimg.setAttribute('title',jp_picaltonoff+jp_subul.parentNode.getElementsByTagName('A')[1].innerHTML);
					jp_momimg.setAttribute('alt',jp_picaltonoff+jp_subul.parentNode.getElementsByTagName('A')[1].innerHTML);
					jp_momimg.src=jp_pic;
					jp_subul.style.display=jp_disp;
				}
			}
		}

		// Suppresion des images qui ne sont pas des plus ou moins
		//for(i=0;i<jp_alllis.length;i++){
		//	jp_mom=jp_alllis[i].getElementsByTagName('A')[0];
		//	if(jp_mom){
		//		jp_momimg=jp_mom.childNodes[0];
		//		if (jp_momimg.src.indexOf(jp_blankpic)!=-1) {
					// remove link and image
		//			jp_mom.parentNode.removeChild(jp_mom);
		//		}					
		//	}
		//	}
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
			jp_img.setAttribute('alt',jp_strAltNew);
		}
	}			
}

sfHover = function() {
	var sfEls = document.getElementById("navMenuTop").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
