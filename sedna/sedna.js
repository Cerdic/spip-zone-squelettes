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

/* une fonction pour modifier la couleur des intertitres du meme site */
function highlight_site(id) {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("h2")[i]); i++) {
    a.className = 'site';
  }
  for(i=0; (a = document.getElementsByName(id)[i]); i++) {
    a.className = 'sitesel';
  }
}

/* gerer le cookie des articles lus */
/* attention on ne doit pas depasser 3ko */
function jai_lu(id) {
  var cookie = readCookie("sedna_lu");
  cookie = cookie ? (id + ' ' + cookie) : id;
  cookie = cookie.substring(0,3000);
  createCookie("sedna_lu", cookie, 365);
  a = document.getElementById('news'+id);
  a.className='linkvu'; /* ce lien change de style */
}

/* Afficher ou masquer les descriptifs */
function style_desc(aff) {
  createCookie("sedna_style", aff, 365);
  for(i=0; (a = document.getElementsByName('desc')[i]); i++) {
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

	if (on == 'oui') {
		document.getElementById('synchrooui').className='selected';
		document.getElementById('synchronon').className='';
	} else {
		document.getElementById('synchrooui').className='';
		document.getElementById('synchronon').className='selected';
	}
}

/* appelee par le body onload */
function sedna_init() {
	sedna_synchro(readCookie('sedna_synchro'));
}
