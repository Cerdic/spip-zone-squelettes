
function masque(identifiant,num) {
		$("dd").each(
				function( intIndex ){
						if ($(this).attr("id")!=$(identifiant).attr("id") && $(this).css("display")!="none" ) $(this).hide('slow');
				}
		);
		$("img.imageplus").each(
				function( intIndex ){
						if ($(this).attr("id")!="img"+num ) $(this).attr({ src: "plugins/scolaspip/images/deplierhaut.png", alt : " - " , title : "Voir les sous-rubriques"});
				}
		);
}

function montre(id,num) {
	masque(id,num);
	if (id!="")
		if ($(id).css("display")=="none") {
				$(id).show('slow');
				$("#img"+num).attr({ src: "plugins/scolaspip/images/deplierbas.png",  alt : " + " , title : "Masquer les sous-rubriques"  });
		}
		else  {
				$(id).hide('slow');
				$("#img"+num).attr({ src: "plugins/scolaspip/images/deplierhaut.png", alt : " - " , title : "Voir les sous-rubriques" });
		}
}
var tout_masque=true;

function montre_tout(){
		if (tout_masque){
				$("dd").each(
						function( intIndex ){
								if ( $(this).css("display")=="none" ) $(this).show('slow');
						}
				);
				$("img.imageplus").each(
						function( intIndex ){
								$(this).attr({ src: "plugins/scolaspip/images/deplierbas.png", alt : " - " , title : "Masquer les sous-rubriques"});
						}
				);
				tout_masque=false;
		}
		else{
				$("dd").each(
						function( intIndex ){
								if ( $(this).css("display")!="none" ) $(this).hide('slow');
						}
				);
				$("img.imageplus").each(
						function( intIndex ){
								$(this).attr({ src: "plugins/scolaspip/images/deplierhaut.png", alt : " + " , title : "Montrer les sous-rubriques"});
						}
				);
				tout_masque=true;
		}

}

