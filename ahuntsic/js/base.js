function deplier(objet){
	d = document.getElementById(objet);
	var etat = d.style.display;
	if (etat!='none') {
	d.style.display = 'none';
	} else {
	d.style.display = 'block';
	}
}

/* si le plugin iSPIP pour iPhone est active */
function iPhoneAlert() {
	if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i))){
	var question = confirm("Souhaitez-vous naviguer sur le site en mode iPhone ?") if (question) {
	window.location = "#URL_PAGE{ispip}";
	} else {

}
}
}
