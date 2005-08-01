/* Fixer le path du cookie sur le repertoire local (et non pas /) */
function recuperer_cookiepath() {
	var cookiepath = location.href;
	/* remonter au repertoire */
	cookiepath = cookiepath.substring(0,cookiepath.lastIndexOf('/'));
	/* supprimer la methode http:// */
	cookiepath = cookiepath.substring(cookiepath.indexOf('://')+3);
	/* supprimer hostname */
	cookiepath = cookiepath.substring(cookiepath.indexOf('/')+1);
	/* alert(cookiepath); */
	return cookiepath;
}

/* create- and readCookie are adapted from (c) Paul Sowden http://www.alistapart.com/articles/alternate/ */
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else expires = "";
	document.cookie = name+"="+value+expires+"; path=/"+recuperer_cookiepath();
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


/*
 * Fonctions pour Sedna (c) Fil -- GNU/GPL
 */

/* une fonction pour modifier l'affichage des item d'un site */
function change_site(id) {
	var cookie = readCookie('sedna_ignore_'+id);

	/* supprimer le site du cookie */
	if (cookie) {
		createCookie('sedna_ignore_'+id, '', -1);
	} else {
		createCookie('sedna_ignore_'+id, 1, 365);
	}

//	afficher_sites();
}

function afficher_sites() {
	d = document.getElementsByTagName("li");
	for(i=0; (a = d[i]); i++) {
		if ((a.id.substr(0,4) == 'item')
		&& (site = a.id.substr(4, -4 + a.id.indexOf('_')))) {
			if (readCookie('sedna_ignore_'+site)) {
				a.className = 'itemoff';
			} else {
				a.className = 'item';
			}
		}
	}
}

/* ne sert plus : changer de couleur quand on clique */
function highlight_site(id) {
	var i,d,a,c;

	c = 'site'+id+'_';
	d = document.getElementsByTagName("h2");
	for(i=0; (a = d[i]); i++) {
		if (a.id.substr(0,c.length) == c) {
			a.className = 'sitesel';
		} else {
			a.className = 'site';
		}
	}

}

/* gerer le cookie des articles lus */
/* attention on ne doit pas depasser 3ko */
function jai_lu(id) {
	if (!est_lu(id)) {
		sedna_nouv--;
		var cookie = readCookie("sedna_lu");
		cookie = cookie ? (id + '-' + cookie) : id;
		cookie = cookie.substring(0,3000);
		createCookie("sedna_lu", cookie, 365);
		var a = document.getElementById('news'+id);
		a.className='linkvu'; /* ce lien change de style */
		document.title = sedna_title+' ('+sedna_nouv+'/'+sedna_total+')';
	}
}

/* Afficher ou masquer les descriptifs */
function style_desc(aff) {
	var a;
	var c=1;
	createCookie("sedna_style", aff, 365);
	while (a = document.getElementById('desc_'+(c++))) {
		a.className="desc_"+aff;
	}
	if (aff == 'masquer') {
		document.getElementById('desc_masquer').className='selected';
		document.getElementById('desc_afficher').className='';
	} else {
		document.getElementById('desc_masquer').className='';
		document.getElementById('desc_afficher').className='selected';
	}
}

/* passer en mode synchro */
function sedna_synchro(on) {
	if (on == 'oui') {
		createCookie('sedna_synchro', 'oui', 365);
	} else if (on == 'non') {
		createCookie('sedna_synchro', '', 0);
	}

	if (document.getElementById('synchrooui')) {
		if (on == 'oui') {
			document.getElementById('synchrooui').className='selected';
			document.getElementById('synchronon').className='';
		} else {
			document.getElementById('synchrooui').className='';
			document.getElementById('synchronon').className='selected';
		}
	}
}

// nous dit si l'article id est lu ou pas
function est_lu(id) {
	var cookie = '--'+escape(readCookie("sedna_lu"))+'-';
	return (cookie.indexOf('-'+id+'-') > 0);
}

/*
	appelee par le body onload pour remettre le bon etat sur les
	liens qui ont change de couleur mais qui se trouvent sur des
	pages valables dans le cache du navigateur
*/
function sedna_init() {

	// regler la position du bouton "synchro"
	sedna_synchro(readCookie('sedna_synchro'));

	// globals
	sedna_nouv = 0;
	sedna_total =0;

	var a,d,i;
	d = document.getElementsByTagName('a');
	for(i=0; a=d[i]; i++) {
		if (a.id
		&& (a.id.substr(0,4) == 'news')) {
			if (est_lu(a.id.substr(4))) {
				a.className='linkvu';
			} else {
				sedna_nouv++;
			}
			sedna_total++;
		}
	}

	// Marquer dans la barre de titre le nombre d'articles nouveaux
	sedna_title = document.title;
	document.title = sedna_title + ' (' + sedna_nouv + '/' + sedna_total + ')';

	afficher_sites();
}
