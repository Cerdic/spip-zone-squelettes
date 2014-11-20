
function hexdec(h){
	return parseInt(h, 16);
}

function dechex(d){
	return Math.round(d).toString(16);
}

function couleur_rvb(hex){
	hex = hex.replace("#","");
	couleur = new Array();

	if (hex.length==6){
		couleur['r'] = hex.substr(0,2);
		couleur['v'] = hex.substr(2,2);
		couleur['b'] = hex.substr(4,2);
	} else if (hex.length==3){
		couleur['r'] = hex.substr(0,1).concat(hex.substr(0,1));
		couleur['v'] = hex.substr(1,1).concat(hex.substr(1,1));
		couleur['b'] = hex.substr(2,1).concat(hex.substr(2,1));		
	} else {
		/* blanc */
		couleur['r'] = couleur['v'] = couleur['b'] = 'ff';
	}
	
	/* en decimal */
	couleur['r'] = hexdec(couleur['r']);
	couleur['v'] = hexdec(couleur['v']);
	couleur['b'] = hexdec(couleur['b']);
	
	return couleur;
}

function couleur_hex(dec){
	var hex = new Array();
	hex['r'] = dechex(dec['r']);
	hex['v'] = dechex(dec['v']);
	hex['b'] = dechex(dec['b']);	

	if (hex['r'] == '0') { hex['r'] = '00';}
	if (hex['v'] == '0') { hex['v'] = '00';}
	if (hex['b'] == '0') { hex['b'] = '00';}
	
	return '#' + hex['r'] + hex['v'] + hex['b'];	
}

function calculer_couleur(base, kr, kv, kb){

	rvb = couleur_rvb(base);
	
	/* calculs */
	if ((rvb['r'] == 255) && (rvb['v'] == 255) && (rvb['b'] == 255)) 
		{return '#ffffff';}
	if ((rvb['r'] == 0) && (rvb['v'] == 0) && (rvb['b'] == 0)) 
		{return '#000000';}
	
	
	if (kr >  1) kr =  1;
	if (kr < -1) kr = -1;
	if (kv >  1) kv =  1;
	if (kv < -1) kv = -1;
	if (kb >  1) kb =  1;
	if (kb < -1) kb = -1;
	
	if (kr>=0) 
		{rvb['r'] = rvb['r'] + kr * (255-rvb['r']);}
	else
		{rvb['r'] = rvb['r'] + kr * rvb['r'];}
	
	if (kv>=0) 
		{rvb['v'] = rvb['v'] + kv * (255-rvb['v']);}
	else
		{rvb['v'] = rvb['v'] + kv * rvb['v'];}
	
	if (kb>=0) 
		{rvb['b'] = rvb['b'] + kb * (255-rvb['b']);}
	else
		{rvb['b'] = rvb['b'] + kb * rvb['b'];}	

	if (rvb['r']>255) rvb['r']=255;
	if (rvb['v']>255) rvb['v']=255;
	if (rvb['b']>255) rvb['b']=255;
	
	if (rvb['r']<0) rvb['r']=0;
	if (rvb['v']<0) rvb['v']=0;
	if (rvb['b']<0) rvb['b']=0;
	
	return couleur_hex(rvb);	
}

function trouver_couleur(type, kr, kb, kv){
	var base;
	if (type=='dominante'){base = '#cccccc';}
	if (type=='generale') {base = '#f6f6f6';}
	
	if (!kr && kr !== 0) {kr = parseFloat($("#mfx_coef_rouge").prop('value'));}
	if (!kv && kv !== 0) {kv = parseFloat($("#mfx_coef_vert").prop('value'));}
	if (!kb && kb !== 0) {kb = parseFloat($("#mfx_coef_bleu").prop('value'));}
	
	
	/*kv = parseFloat($("#mfx_coef_vert").attr('value'));
	kb = parseFloat($("#mfx_coef_bleu").attr('value'));*/
	
	return calculer_couleur(base, kr, kv, kb);
}

jQuery(document).ready(function() {
	
	/* ------- INIT -------- */
	$("#mfx_dominante_ori").
		css('background-color', trouver_couleur('dominante',0,0,0));
	$("#mfx_generale_ori").
		css('background-color', trouver_couleur('generale',0,0,0));
	$("#mfx_dominante_now, #mfx_dominante_new").
		css('background-color', trouver_couleur('dominante'));
	$("#mfx_generale_now, #mfx_generale_new").
		css('background-color', trouver_couleur('generale'));
	
	/* ------- SUR CHANGEMENTS -------- */
	$(".def_teintes input").keyup(function(){
		$("#mfx_dominante_new").
			css('background-color', trouver_couleur('dominante'));
		$("#mfx_generale_new").
			css('background-color', trouver_couleur('generale'));	
	});			
	$(".def_teintes input").change(function(){
		if(this.value>1)  {this.value=1};
		if(this.value<-1) {this.value=-1};
		$("#mfx_dominante_new").
			css('background-color', trouver_couleur('dominante'));
		$("#mfx_generale_new").
			css('background-color', trouver_couleur('generale'));			
	});
	
	
});
