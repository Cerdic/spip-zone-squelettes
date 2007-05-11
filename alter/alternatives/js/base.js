function deplier(objet){
	d = document.getElementById(objet);
	var etat = d.style.display;
	if (etat!='none') {
	d.style.display = 'none';
	} else {
	d.style.display = 'block';
	}
}