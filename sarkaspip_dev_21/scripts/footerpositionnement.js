function setFooter() {
	var gaucheHeight=0;
	var centreHeight=0;
	var droiteHeight=0;
	var heightGDMax;

	if (document.getElementById('gauche')) {
		gaucheHeight=document.getElementById('gauche').offsetHeight;
	}
	if (document.getElementById('droite')) {
		droiteHeight=document.getElementById('droite').offsetHeight;
	}
	centreHeight=document.getElementById('centre').offsetHeight;

	heightGDMax = Math.max(droiteHeight, gaucheHeight)
	if (heightGDMax>centreHeight){
	   document.getElementById('centre').style.height=(heightGDMax)+'px';
	}
}