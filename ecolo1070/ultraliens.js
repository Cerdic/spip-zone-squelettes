/********************************************************************/
/*  ULTRALIENS - CSS                                                */
/*  License Creative Commons BY                                     */
/*  http://creativecommons.org/licenses/by/2.0/fr/                  */
/*  08 septembre 2006 - V2.0                                        */
/*  Gr?ory Cl?ent - YellowPimento - http://www.yellowpimento.com  */
/*  Plus d'info : http://www.ultraliens.com                         */
/********************************************************************/


// Espacement entre le curseur et l'ultralien
cursor_paddingX = 15;
cursor_paddingY = 10;

isVisible = false;
ie = document.all;

// R?up?e les coordonn?s de la souris
// les affecte au style du div ultraliens
function get_mouse(e){
	x = (navigator.appName.substring(0,3) == "Net") ? e.pageX+cursor_paddingX : event.clientX+document.documentElement.scrollLeft+cursor_paddingX;
	y = (navigator.appName.substring(0,3) == "Net") ? e.pageY+cursor_paddingY : event.clientY+document.documentElement.scrollTop+cursor_paddingY;
	bubble = document.getElementById("ultraliens");
	if(isVisible){
		//////////////////////////////////
		// AMELIORATION V2.0
		//////////////////////////////////
		// On inverse le x ou le y pour les moiti? sup?ieures de l'?ran (droite et bas)
		// Merci Tijuan.net !
		bubble.style.left = (x>(document.body.clientWidth/2)?x-350:x) + 'px';
		bubble.style.top = (y>(document.body.clientHeight/2)?y-70:y) + 'px';
	} else {
		// pour ?iter les scrolls intempestifs quand le curseur n'est pas sur un lien
		bubble.style.left = "-999em";
		bubble.style.top = "0";
	}
}

//////////////////////////////////
// NOUVEAUTE V2.0
//////////////////////////////////
// Cr?tion des ultraliens en objet
ultraliens = {
	init: function() {
		var liens = document.getElementsByTagName('a');
		var bubble = document.getElementById("ultraliens");
	
		for( var nblien = 0 ; nblien < liens.length ; nblien++){
			if(liens[nblien].className.indexOf('ultralien')>-1){
	
				liens[nblien].onmouseover = function(){
		
					isVisible = true;
		
					/******* DEFINITION DU H1 ******/
					
					// Cr?tion du h1
					var h1_node = document.createElement('h1');
					bubble.appendChild(h1_node);
					// Cas par d?aut
					h1text = "Lien";
					// Attribution du contenu
					if(this.className.indexOf('ultralien_menu')>-1){
						h1text = "Menu";
					}
					if(this.className.indexOf('ultralien_fonction')>-1){
						h1text = "Fonction";
					}
					if(this.className.indexOf('ultralien_auteur')>-1){
						h1text = "Auteur";
					}
					if(this.className.indexOf('ultralien_source')>-1){
						h1text = "Source";
					}
					if(this.className.indexOf('ultralien_reference')>-1){
						h1text = "R??ence";
					}
					if(this.className.indexOf('ultralien_exemple')>-1){
						h1text = "Exemple";
					}
					if(this.className.indexOf('ultralien_courriel')>-1){
						h1text = "Courriel";
					}
					if(this.className.indexOf('ultralien_complement')>-1){
						h1text = "Descriptif";
					}
					if(this.className.indexOf('ultralien_traduction')>-1){
						h1text = "Traduction";
					}
					if(this.className.indexOf('ultralien_pub')>-1){
						h1text = "Pub";
					}
					if(this.className.indexOf('ultralien_acronyme')>-1){
						h1text = "Acronyme";
					}
					if(this.className.indexOf('ultralien_multimedia')>-1){
						h1text = "Multimedia";
					}
					if(this.className.indexOf('ultralien_site')>-1){
						h1text = "Site web";
					}
		/*			// Ce cas est  r??er pour tous les styles de liens que vous aurez d?inis
					if(this.className.indexOf('ultralien_xxx')>-1){
						h1text = "Text du xxx";
					}
		*/
					if(this.className.indexOf('ultralien_externe')>-1){
						// ici on ajoute un texte dans le cas d'une nouvelle fen?re
						h1text += " [+]";
					}
					
					//////////////////////////////////
					// NOUVEAUTE V1.2
					//////////////////////////////////
					// On affiche la langue correspondante au hreflang du lien s'il existe (D?ommentez les deux lignes suivantes si vous ne souhaitez voir la langue qu'en mode texte)
					//if(this.hreflang)
					//	h1text += " (" + this.hreflang + ")";
					h1_contenu = document.createTextNode(h1text);
					bubble.firstChild.appendChild(h1_contenu);
		
					
					//////////////////////////////////
					// NOUVEAUTE V1.2
					//////////////////////////////////
					// On affiche le drapeau de la langue correspondante au hreflang du lien s'il existe (Commentez les lignes suivantes si vous ne souhaitez voir la langue qu'en mode texte)
					if(this.hreflang){
						var img = document.createElement("img");
						img.src = "ultraliens/flags/"+this.hreflang+".gif";
						img.border = 0;
						bubble.lastChild.appendChild(img);
					}
					
					
					// Attribution de la classe
					// ATTENTION : vous pouvez aussi d?inir un style diff?ent pour chaque h1 utilis ici, puisqu'on y adjoint la classe.
					bubble.firstChild.className = this.className;
		
		
		
					/******* DEFINITION DU CAS EXTERNE (DIV) ******/
		
					// Cr?tion du div
					if(this.className.indexOf('ultralien_externe')>-1){
						var div_node = document.createElement('div');
						bubble.appendChild(div_node);
						// Attribution de la class "ultralien_externe"
						bubble.lastChild.className = "ultralien_externe";
					}
		
		
					
					
					
					/******* DEFINITION DU DECOR (DIV) ******/
					// Attention  bien faire correspondre chaque d?inition avec la CSS
					// Cr?tion du div
					var div_node = document.createElement('div');
					bubble.appendChild(div_node);
					// Attribution de la class sans "ultralien_externe"
					bubble.lastChild.className = (this.className.indexOf('ultralien_externe')>-1?this.className.substr(0,this.className.indexOf('ultralien_externe')-1):this.className);
					
					
					
					
					/******* DEFINITION DU P ******/
		
					// Cr?tion du p
					var p_node = document.createElement('p');
					bubble.appendChild(p_node);
					
					// Attribution du contenu de l'attribut title du lien initial
					p_contenu = document.createTextNode(this.title);
					bubble.lastChild.appendChild(p_contenu);
		
					//////////////////////////////////
					// NOUVEAUTE V1.3
					//////////////////////////////////
					// On affiche la vignette g??? par Girafa.com (via MSNSEARCH)
					if(this.className.indexOf('ultralien_vignette')>-1){
						var thumbsrc= this.href.replace(/[^:]*:\/\/([^:\/]*)(:{0,1}\/{1}.*)/,'$1');
						var img = document.createElement("img");
						img.src = "http://msnsearch.srv.girafa.com/srv/i?s=MSNSEARCH&r="+thumbsrc;
						img.border = 0;
						bubble.lastChild.appendChild(img);
					}
		
					// Attribution de la class
					bubble.lastChild.className = this.className;
		
					
					
					
					/******* AFFICHAGE DE L'ULTRALIEN ******/
					bubble.style.visibility = "visible";
					// On sauvegarde le title du lien pour le r?ffecter ensuite
					texte = this.title;
					// On vide le title pour ?iter l'occurence
					this.title = "";
				}
		
		
		
				
				liens[nblien].onmouseout = function(){
		
					isVisible = false;
					// On efface tous les ??ents cr?s dans le onmouseover
					while(bubble.childNodes[0])
						bubble.removeChild(bubble.childNodes[0]);
					bubble.style.visibility = "hidden";
					//on r?ffecte le title au lien
					if(this.title.length==0) this.title = texte;
				}
		
		
		
				// ouverture dans un lien externe
				if(liens[nblien].className.indexOf('ultralien_externe')>-1){
					liens[nblien].onclick = function(){
						window.open(this.href);
						return false; 
					}
				}
			}
		}
	},
	
	//pour lancer le body.onload
	addEvent: function(element, eventType, doFunction, useCapture){
		if (element.addEventListener) 
		{
			element.addEventListener(eventType, doFunction, useCapture);
			return true;
		} else if (element.attachEvent) {
			var r = element.attachEvent('on' + eventType, doFunction);
			return r;
		} else {
			element['on' + eventType] = doFunction;
		}
	}
}

//////////////////////////////////
// NOUVEAUTE V2.0
//////////////////////////////////
// Initialisation des ultraliens
ultraliens.addEvent(window, 'load', ultraliens.init, false);