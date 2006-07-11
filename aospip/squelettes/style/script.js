function montre(id, elem) {

var d = document.getElementById(id);
var nomelem = elem.id;

if (d.style.display=="block") { d.style.display = "none"; document.getElementById(nomelem).style.backgroundImage = 'url(./squelettes/style/plus.gif)'; } else { d.style.display="block"; document.getElementById(nomelem).style.backgroundImage = 'url(./squelettes/style/moins.gif)'; }

}
function montrec(id, elem) {

var d = document.getElementById(id);

if (d.style.display=="block") { d.style.display = "none"; document.getElementById(elem).style.backgroundImage = 'url(./squelettes/style/plus.gif)'; } else { d.style.display="block"; document.getElementById(elem).style.backgroundImage = 'url(./squelettes/style/moins.gif)'; }

}