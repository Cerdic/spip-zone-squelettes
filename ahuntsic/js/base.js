/* si le plugin iSPIP pour iPhone est active */
function iPhoneAlert() {
	if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i))){
	var question = confirm("Souhaitez-vous naviguer sur le site en mode iPhone ?") if (question) {
	window.location = "#URL_PAGE{ispip}";
	} else {

}
}
}
