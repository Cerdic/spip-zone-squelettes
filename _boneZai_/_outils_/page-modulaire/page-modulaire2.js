/*
  Copyright (C) 2005  Pierre ANDREWS

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/***********************************************************************
configuration
 ***********************************************************************/

var pmod_host = "http://mortimer.rezo.net";

/***********************************************************************
les globales
**********************************************************************/

var lesNoisettes = new Array();
var buttonState = 'lesnoisettes';

var quoiou = new Array();
var UID = 0;

var toolDiv;
var lesNoisettesSidebar;
var sidebarCreation;

var splash;

var lebody;
var oldBackground;
var oldBodyClass;

/***********************************************************************
les objets pour l'interface
***********************************************************************/

function Button(icon, text, handler) {
	this.icon =icon;
	this.text =text;
	this.handler = handler;

	this.display = function() {
		var but = document.createElement('div');
		but.className = 'button';
		var link = document.createElement('a');
		link.onclick = this.handler;
		var icone = document.createElement('img');
		icone.src = this.icon;
		icone.alt = this.text;
		link.appendChild(icone);
		var tn = document.createTextNode(this.text);
		link.appendChild( document.createElement('span').appendChild(tn));
		but.appendChild(link);
		return but;
	}
}

function ToolBar() {

	this.buttons = new Array();
	this.container;

	this.addButton = function(button) {
		this.buttons.push(button);
	}

	this.display = function() {
		this.container = document.createElement('div');
		for(var i=0; i<this.buttons.length;i++) {
			this.container.appendChild(this.buttons[i].display());
		}
		this.container.className = 'toolbar';
		this.container.id = 'pmod-toobar';
		return this.container;
	}

}

function SideBar() {

	this.items = new Array();
	this.container;
	this.shown = true;

	this.selectedID = -1;

	this.deselect = function() {
		if(this.selectedID >= 0) {
			this.items[this.selectedID].unselect();
		}
	}

	this.getSelected = function() {
		if(this.selectedID >= 0) {
			return this.items[this.selectedID];
		}
		return null;
	}

	this.addItem = function(item) {
		item.setID(this.items.length);
		this.items.push(item);
	}

	this.display = function() {
		this.container = document.createElement('div');
		this.container.className = 'sidebar';		
		this.container.id = 'pmod-sidebar';
		var list = document.createElement('ul');
		for(var i=0; i<this.items.length;i++) {
			list.appendChild(this.items[i].display());
		}
		this.container.appendChild(list);
		return this.container;
	}
	
	this.showhide = function() {
		if(this.shown) 
			this.container.style.display = 'none';
		else
			this.container.style.display = 'block';
		this.shown = !this.shown;
	}

}

function ItemNoisette(nom, squelette, descShort, descLong, props) {
	this.nom = nom;
	this.squelette = squelette;
	this.descShort = descShort;
	this.descLong = descLong;
	this.props = props;

	this.id;

	var self = this;

	this.container;

	this.selected = function() {
		this.container.className = 'selected';
		lesNoisettesSidebar.deselect();
		lesNoisettesSidebar.selectedID = this.id;
	}

	this.unselect = function() {
		this.container.className = '';
	}

	this.setID = function(id) {
		this.id = id;
	}

	this.display = function() {
		this.container = document.createElement('li');
		this.container.onclick = function(ev) {
			self.selected();
		};
		this.container.appendChild(document.createElement('strong').appendChild(document.createTextNode(this.nom)));
		var shortSpan = document.createElement('span');
		shortSpan.className = 'short';
		shortSpan.appendChild(document.createTextNode(this.descShort));
		this.container.appendChild(shortSpan);
		var longSpan = document.createElement('span');
		longSpan.className = 'long';
		longSpan.appendChild(document.createTextNode(this.descLong));
		this.container.appendChild(longSpan);
		return this.container;
	}
}

function SideBarCreationBloc() {
	this.elemType = document.createElement('input');
	this.elemClass = document.createElement('input');
	this.elemContent = document.createElement('textarea');

	this.container;
	this.shown = true;

	this.display = function() {
		this.container = document.createElement('form');
		this.container.className = 'sidebar';
		this.container.id = 'pmod-sidebar-creation';

		var label1 = document.createElement('label');
		label1.htmlFor = 'elemType';
		label1.appendChild(document.createTextNode('Type:'));
		this.elemType.id = this.elemType.name = 'elemType';
		this.elemType.value = 'div';
		this.container.appendChild(label1);
		this.container.appendChild(this.elemType);
		this.container.appendChild(document.createElement('br'));
		
		var label2 = document.createElement('label');
		label2.htmlFor = 'elemClass';
		label2.appendChild(document.createTextNode('Class:'));
		this.elemClass.id = this.elemClass.name = 'elemClass';
		this.container.appendChild(label2);
		this.container.appendChild(this.elemClass);
		this.container.appendChild(document.createElement('br'));
		
		var label3 = document.createElement('label');
		label3.htmlFor = 'elemContent';
		label3.appendChild(document.createTextNode('Contenu:'));
		this.elemContent.id = this.elemContent.name = 'elemContent';
		this.elemContent.value = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed mattis adipiscing erat. Nulla feugiat orci sit amet libero. Proin nibh. In cursus risus ut sem. Suspendisse potenti. Nulla facilisi. Ut dictum, tortor vitae convallis vehicula, ante ipsum consectetuer diam, in vulputate odio libero vitae sapien. Suspendisse egestas mauris facilisis diam nonummy volutpat. Praesent consequat, tortor in iaculis adipiscing, neque risus auctor nibh, sit amet adipiscing massa ipsum vel metus. Sed mollis urna. Integer iaculis condimentum diam. Sed ac ante. Nam feugiat lectus vitae dolor aliquet vulputate. Fusce nisl eros, ultricies feugiat, molestie quis, ultricies id, leo. Nulla et enim hendrerit arcu mollis nonummy.";
		this.container.appendChild(label3);
		this.container.appendChild(this.elemContent);
		this.container.appendChild(document.createElement('br'));
		

		return this.container;		
	}

	this.getElemType = function() {
		return this.elemType.value;
	}

	this.getElemClass = function() {
		return this.elemClass.value;
	}

	this.getElemContent = function() {
		return this.elemContent.value;
	}

	this.showhide = function() {
		if(this.shown) 
			this.container.style.display = 'none';
		else
			this.container.style.display = 'block';
		this.shown = !this.shown;
	}
}

function SaveDialog(codeToSave) {

  this.toSave = codeToSave;
  this.container;
  var self = this;

  this.display = function() {
	this.container = document.createElement('div');
	this.container.className = 'saveDialog';
	this.container.id = 'pmod-save';
	var close = this.container.appendChild(document.createElement('a'));
	close.appendChild(document.createTextNode('fermer'));
	close.onclick = this.close;
	this.container.appendChild(close);
	this.container.appendChild(document.createElement('br'));
	var textarea = document.body.appendChild(document.createElement('textarea'));
	textarea.value = this.toSave;
    textarea.cols = 70;
    textarea.rows = 20;
	this.container.appendChild(textarea);
	return this.container;
  }

  this.close = function() {
	document.body.removeChild(self.container);
  }

}

function Splash(icon, message) {

  this.container;

  this.icon = icon;
  this.message = message;

  this.display = function() {
	this.container = document.createElement('div');
	this.container.className = 'splashscreen';
	this.container.id = 'pmod-splash';
	img = this.container.appendChild(document.createElement('img'));
	img.src = icon;
	img.alt = message;
	txt = this.container.appendChild(document.createElement('span'));
	txt.innerHTML = message;
	document.body.appendChild(this.container);
  }

  this.destroy = function() {
	document.body.removeChild(this.container);
  }

}


/***********************************************************************
les events
***********************************************************************/

function clickHandler(ev,tg) {

	ev.cancelBubble = true;
	if (ev.stopPropagation) ev.stopPropagation();

	var realTarget = (ev.target) ? ev.target : ev.srcElement;
	if(realTarget == tg)
		switch(buttonState) {
			case 'creerbloc':
				addElement(sidebarCreation.getElemType(),tg,sidebarCreation.getElemClass(),sidebarCreation.getElemContent());
				break;
			case 'lesnoisettes':
				if(tg != document.body)
					putHere(tg);
				break;
			case 'effacerbloc':
				if(tg != document.body)
					tg.parentNode.removeChild(tg);
				break;
		}
}

function mouseOverColor(ev) {
	ev.cancelBubble = true;
	if (ev.stopPropagation) ev.stopPropagation();
  oldBackground = this.style.backgroundColor;
  this.style.backgroundColor = "#C0C0C0";
}

function mouseOutColor(ev) {
	ev.cancelBubble = true;
	if (ev.stopPropagation) ev.stopPropagation();
  	try {
		this.style.backgroundColor=oldBackground;
	} catch(err) { }
}

/***********************************************************************
pour l'ajax
***********************************************************************/

var xmlhttp = new Array();
var url_chargee = new Array();
var modulerequest;

function charger_id_url_dans_elem(myUrl,elem) {
	info("charge l'url:" +myUrl);

	if (xmlhttp[elem]) xmlhttp[elem].abort();
	
	if (url_chargee['mem_'+myUrl]) {
		elem.innerHTML = url_chargee['mem_'+myUrl];
	} else {
		if(window.XMLHttpRequest) {
			xmlhttp[elem] = new XMLHttpRequest(); 
		} else if(window.ActiveXObject) {
			xmlhttp[elem] = new ActiveXObject("Microsoft.XMLHTTP");
		} else {
			error("AJAX pas support&eacute;");
			return false;
		}
		xmlhttp[elem].open("GET", myUrl, true);

		xmlhttp[elem].onreadystatechange = function() {
			if (xmlhttp[elem].readyState == 4) { 
				if(xmlhttp[elem].responseText.length > 0) {
					elem.innerHTML = xmlhttp[elem].responseText; // puts the result into the element
					url_chargee['mem_'+myUrl] = xmlhttp[elem].responseText;
					//		error("pas d'erreur");
				} else {
					error("erreur AJAX: pas de retour");
				}
			}
		}
		xmlhttp[elem].send(null); 
		return true;
	}
	return false;
}

function construireListeModule() {
	if(modulerequest != null) modulerequest.abort();
	var toReturn = new Array();

	if(window.XMLHttpRequest) {
		modulerequest = new XMLHttpRequest(); 
	} else if(window.ActiveXObject) {
		modulerequest = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		alert("ajax pas supporte");
		return false;
	}
	modulerequest.open("GET", './list-modules.php', true);
  

	modulerequest.onreadystatechange = function() {
		if (modulerequest.readyState == 4) { 
			if((modulerequest.status == 200) && (modulerequest.responseXML != null)) {
				var lesmodules = modulerequest.responseXML.getElementsByTagName('noisette');
		
				for(var i=0;i<lesmodules.length;i++) {
					for(var j=0;j<lesmodules.item(i).childNodes.length;j++) {
						var nom, squelette, shortDesc, longDesc;
						switch(lesmodules.item(i).childNodes.item(j).nodeName) {
							case 'squelette':
								squelette = lesmodules.item(i).childNodes.item(j).childNodes[0].nodeValue;
								break;
							case 'nom':
								nom = lesmodules.item(i).childNodes.item(j).childNodes[0].nodeValue;
								break;
							case 'long':
								longDesc = lesmodules.item(i).childNodes.item(j).childNodes[0].nodeValue;
								break;
							case 'short':
								shortDesc = lesmodules.item(i).childNodes.item(j).childNodes[0].nodeValue;
								break;
							case 'properties':
								break;
						}
					}
					lesNoisettes.push(new ItemNoisette(nom, squelette, shortDesc, longDesc, null));
				}
				listeModuleDone();
			} else {
				alert("pbl");
			}
		}
	}
	modulerequest.send(null); 
	return true;
}

/***********************************************************************
...
***********************************************************************/

function addEvent(elem) {
	elem.onclick = function(ev) {
		clickHandler(ev,this);
	};
	if(elem.tagName != "BODY") {
	  elem.onmouseover = mouseOverColor;
	  elem.onmouseout = mouseOutColor;
	}
}

function addEventRecursive(elem) {

	addEvent(elem);
	if(elem.hasChildNodes())
		for(var i=0;i<elem.childNodes.length;i++) {
			addEventRecursive(elem.childNodes.item(i));
		}
  
}

function pm_init() {
  lebody = document.body;
  oldBodyClass = lebody.className;
  lebody.className += " lebody";
  var lecss = document.createElement("link");
  lecss.rel = "Stylesheet";
  lecss.type="text/css";
  lecss.id="pmod-css";
  lecss.href=pmod_host+"/squelettes/page-modulaire.css";
  document.getElementsByTagName('head').item(0).appendChild(lecss);

  //pour le debug
  var lescript = document.createElement("script");
  lescript.id="fvlogger-js";
  lescript.language="javascript";
  lescript.type="text/javascript";
  lescript.src = pmod_host+"/squelettes/fvlogger/logger.js";
  document.getElementsByTagName('head').item(0).appendChild(lescript);
  var lecss2 = document.createElement("link");
  lecss2.rel = "Stylesheet";
  lecss2.type= "text/css";
  lecss2.id = "fvlogger-css";
  lecss2.href= pmod_host+"/squelettes/fvlogger/logger.css";
  document.getElementsByTagName('head').item(0).appendChild(lecss2);

  splash = new Splash(pmod_host+'/squelettes/img/stock_new-labels-48.png','En chargement,<br/> patienter...');
  splash.display();

  /*lebody = document.createElement('div');
	lebody.id = 'lebody';
	for(var i =0;i<document.body.childNodes.length;i++) {
		var clone = document.body.childNodes.item(i).cloneNode();
		lebody.appendChild(clone);
		document.body.removeChild(document.body.childNodes.item(i));
		}*/
	addEventRecursive(lebody);
	var debugDiv = document.body.appendChild(document.createElement('div'));
	debugDiv.id = "fvlogger";
	debugDiv.innerHTML = "<dl><dt>fvlogger</dt><dd class='all'><a href='#fvlogger' onclick='showAll();' title='show all'>all</a></dd><dd class='debug'><a href='#fvlogger' onclick='showDebug();' title='show debug'>debug</a></dd><dd class='info'><a href='#fvlogger' onclick='showInfo();' title='show info'>info</a></dd><dd class='warn'><a href='#fvlogger' onclick='showWarn();' title='show warnings'>warn</a></dd><dd class='error'><a href='#fvlogger' onclick='showError();' title='show errors'>error</a></dd><dd class='fatal'><a href='#fvlogger' onclick='showFatal();' title='show fatals'>fatal</a></dd><dd><a href='#fvlogger' onclick='eraseLog(true);' title='erase'>erase</a></dd></dl>";
	construireListeModule();
}

function listeModuleDone() {
	lesNoisettesSidebar = new SideBar();
	for(var i=0;i<lesNoisettes.length;i++) {
		lesNoisettesSidebar.addItem(lesNoisettes[i]);
	}
	sidebarCreation = new SideBarCreationBloc();

	toolDiv = new ToolBar();
	toolDiv.addButton(new Button(pmod_host+'/squelettes/img/stock_new-labels-48.png','Placer Noisette',function() {sidebarCreation.showhide(); lesNoisettesSidebar.showhide(); buttonState = 'lesnoisettes';}));
	toolDiv.addButton(new Button(pmod_host+'/squelettes/img/stock_insert-celss.png','Creer Bloc',function() {sidebarCreation.showhide(); lesNoisettesSidebar.showhide(); buttonState = 'creerbloc';}));
	toolDiv.addButton(new Button(pmod_host+'/squelettes/img/stock_delete.png','Effacer Bloc',function() {sidebarCreation.showhide(); lesNoisettesSidebar.showhide(); buttonState = 'effacerbloc';}));
	toolDiv.addButton(new Button(pmod_host+'/squelettes/img/stock_save_as.png','Sauver',function() {sauver();}));
	toolDiv.addButton(new Button(pmod_host+'/squelettes/img/stock_stop.png','Quitter',function() {fermer();}));

	var item0 = lebody.childNodes.item(0);

	document.body.insertBefore(toolDiv.display(),item0);
	document.body.insertBefore(sidebarCreation.display(),item0);
	document.body.insertBefore(lesNoisettesSidebar.display(),item0);
	sidebarCreation.showhide();
	splash.destroy();
}

function parseProp(props) {
	var params = '';
	for(var i=0;i<props.length;i++) {
		params += '&'+props.item(i).innerHTML;
	}
	return params;
}

function putHere(elem) {
	selected = lesNoisettesSidebar.getSelected();
	if(selected != null) {
		squel = selected.squelette;
		var params = '';
		if(elem.id == '') {
			elem.id = 'pmod-uid-'+UID++;
		}
		quoiou[elem.id] = squel;
		charger_id_url_dans_elem("page.php?fond="+squel+params,elem);
	}
}

function addElement(type,where,className,lorem) {
	var newElem = document.createElement(type);
	addEvent(newElem);
	newElem.appendChild(document.createTextNode(lorem));
	newElem.className = className;
	where.appendChild(newElem);
}

function addProp() {
	var li = document.createElement('li');
	li.innerHTML = addpropText.value;
	listProp.appendChild(li);
}

/***********************************************************************
Clean up
 ***********************************************************************/

function removeEvent(elem) {
  elem.onclick = null;
	if(elem.tagName != "BODY") {
	  elem.onmouseover = null;
	  elem.onmouseout = null;
	}
}

function removeEventRecursive(elem) {

	removeEvent(elem);
	if(elem.hasChildNodes())
		for(var i=0;i<elem.childNodes.length;i++) {
			removeEventRecursive(elem.childNodes.item(i));
		}
  
}

function sauverElem(elem) {
	if(!((elem.id=="fvlogger") ||
	   (elem.id == 'pmod-toobar') ||
	   (elem.id == 'pmod-sidebar') ||
		 (elem.id == 'pmod-sidebar-creation'))) {
		if(elem.nodeType == 1) { //element node
			var avant = '<'+elem.tagName;
			var milieu = '';
			var fin = '';
			if(elem.hasAttributes())
				for(var i=0;i<elem.attributes.length;i++) {
					if((elem.attributes.item(i).nodeValue != '') || !(elem.attributes.item(i).nodeValue.indexOf('pmod-uid-' == 0)))
						avant += ' '+elem.attributes.item(i).nodeName + '="' + elem.attributes.item(i).nodeValue + '"';
				}
			avant += '>\n';
			if(quoiou[elem.id] != null) {
				milieu = "<INCLURE(page.php3) {fond="+quoiou[elem]+"}>\n";
			} else if(elem.hasChildNodes()) {
				for(var i=0;i<elem.childNodes.length;i++) {
					milieu += sauverElem(elem.childNodes.item(i));
				}
			}
			return avant+milieu+'</'+elem.tagName+'>\n';
		} else if(elem.nodeType == 3) { //text node
			return elem.data;
		}
	}
    return '';
}

function sauver() {
  var squelette = sauverElem(document.body);
  var removed = new Array();
  removed.push(document.getElementsByTagName('head').item(0).removeChild(document.getElementById('fvlogger-js')));
  removed.push(document.getElementsByTagName('head').item(0).removeChild(document.getElementById('fvlogger-css')));
  removed.push(document.getElementsByTagName('head').item(0).removeChild(document.getElementById('pmod-css')));
  removed.push(document.getElementsByTagName('head').item(0).removeChild(document.getElementById('pmod-js')));
  squelette = '<html>\n<head>\n'+document.getElementsByTagName('head').item(0).innerHTML + '\n</head>\n'+squelette+'\n</html>';
  
  for(var i=0;i<removed.length;i++) {
	document.getElementsByTagName('head').item(0).appendChild(removed[i]);
  }

  var saveDial = new SaveDialog(squelette);
  document.body.appendChild(saveDial.display());
}

function fermer() {
  
  if(modulerequest != null) modulerequest.abort();
  for(var i=0;i<xmlhttp.length;i++) {
	xmlhttp[i].abort();
  }

  removeEventRecursive(lebody);
  lebody.className = oldBodyClass;
  document.body.removeChild(lesNoisettesSidebar.container);
  document.body.removeChild(sidebarCreation.container);
  document.body.removeChild(toolDiv.container);
  document.body.removeChild(document.getElementById('fvlogger'));
  document.getElementsByTagName('head').item(0).removeChild(document.getElementById('fvlogger-js'));
  document.getElementsByTagName('head').item(0).removeChild(document.getElementById('fvlogger-css'));
  document.getElementsByTagName('head').item(0).removeChild(document.getElementById('pmod-css'));
  document.getElementsByTagName('head').item(0).removeChild(document.getElementById('pmod-js'));
  document.body.removeChild(document.getElementById('pmod-save'));
}

pm_init();
