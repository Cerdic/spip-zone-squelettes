jQuery(document).ready( function () {

	jQuery('#formulaire_avancee select').change( function () {
		jQuery('#content').html("<div class='patience'><img alt='*' src='plugins/auto/datice3/images/patience.gif' /><br/>Recherche en cours</div>");
 
		// var valmot2=jQuery('#id_mot').val().toString();
		var mots='array(';
		$('.id_groupe').each(function () {	 
	    	if (mots!='array(' && $(this).val()!=0 ){mots=mots+',';}	 
			if($(this).val()!=0){mots=mots + ($(this).val());};	
 		});
		mots=mots+')'; 
  		var valrecherche=jQuery('#recherche-avancee').val().toString();
	
		jQuery('#content').load("spip.php?page=rechercheajax&avancee=1&mots="+mots+"&recherche="+valrecherche);
	});
	
	
	jQuery('#submit-avancee').click( function () {
		
		jQuery('#content').html("<div class='patience'><img alt='*' src='plugins/auto/datice3/images/patience.gif' /><br/>Recherche en cours</div>");
 
		// var valmot2=jQuery('#id_mot').val().toString();
		var mots='array(';
		$('.id_groupe').each(function () {	 
	    	if (mots!='array(' && $(this).val()!=0 ){mots=mots+',';}	 
			if($(this).val()!=0){mots=mots + ($(this).val());};	
 		});
		mots=mots+')'; 
  		var valrecherche=jQuery('#recherche-avancee').val().toString();
	
		jQuery('#content').load("spip.php?page=rechercheajax&avancee=1&mots="+mots+"&recherche="+valrecherche);
		
		return false;
	});

});


