<?php
function balise_INITIALISATION($p) {
   return calculer_balise_dynamique($p,INITIALISATION,array());
       
}

function balise_INITIALISATION_dyn($p) {
	$file0=_DIR_PLUGIN_DATICE."/mep_var.txt";
	$file=fopen($file0,"r");
	while (!feof($file)){
		$ligne=fgets($file,4096);
		if($ligne!=''){
			$tab_ligne=explode("|",$ligne);
			$key=$tab_ligne[0];
			$value=$tab_ligne[1];
			ereg("^'(.*)'$",$value,$regs);
			$value=$regs[1];
			//$value=str_replace("'","",$value);
			$extra[$key]=$value;
		}
	}
	fclose($file);
	switch($p){
		case "lesplus5":
			if($extra['lesplus']=="non"){echo "checked";}
			else{echo " ";};
			break;
		case "lesplus1":
			if($extra['lesplus']=="1"){echo "checked";}
			else{echo " ";};
			break;
		case "lesplus2":
			if($extra['lesplus']=="2"){echo "checked";}
			else{echo " ";};
			break;
		case "lesplus3":
			if($extra['lesplus']=="3"){echo "checked";}
			else{echo " ";};
			break;
		case "lesplus4":
			if($extra['lesplus']=="4"){echo "checked";}
			else{echo " ";};
			break;		

		case "focus5":
			if($extra['focus']=="non"){echo "checked";}
			else{echo " ";};
			break;
		case "focus1":
			if($extra['focus']=="1"){echo "checked";}
			else{echo " ";};
			break;
		case "focus2":
			if($extra['focus']=="2"){echo "checked";}
			else{echo " ";};
			break;
		case "focus3":
			if($extra['focus']=="3"){echo "checked";}
			else{echo " ";};
			break;
		case "focus4":
			if($extra['focus']=="4"){echo "checked";}
			else{echo " ";};
			break;

		case "edito5":
			if($extra['edito']=="non"){echo "checked";}
			else{echo " ";};
			break;
		case "edito1":
			if($extra['edito']=="1"){echo "checked";}
			else{echo " ";};
			break;
		case "edito2":
			if($extra['edito']=="2"){echo "checked";}
			else{echo " ";};
			break;
		case "edito3":
			if($extra['edito']=="3"){echo "checked";}
			else{echo " ";};
			break;
		case "edito4":
			if($extra['edito']=="4"){echo "checked";}
			else{echo " ";};
			break;



		case "image5":
			if($extra['image']=="non"){echo "checked";}
			else{echo " ";};
			break;
		case "image1":
			if($extra['image']=="1"){echo "checked";}
			else{echo " ";};
			break;
		case "image2":
			if($extra['image']=="2"){echo "checked";}
			else{echo " ";};
			break;
		case "image3":
			if($extra['image']=="3"){echo "checked";}
			else{echo " ";};
			break;
		case "image4":
			if($extra['image']=="4"){echo "checked";}
			else{echo " ";};
			break;
		case "choixsom4":
			if($extra['choixsom']=="4"){echo "checked";}
			else{echo " ";};
			break;

		case "choixsom3":
			if($extra['choixsom']=="3"){echo "checked";}
			else{echo " ";};
			break;

		case "choixsom2":
			if($extra['choixsom']=="2"){echo "checked";}
			else{echo " ";};
			break;

		case "choixsom1":
			if($extra['choixsom']=="1"){echo "checked";}
			else{echo " ";};
			break;

		case "menlegoui":
			if($extra['menleg']=="oui"){echo "checked";}
			else{echo " ";};
			break;
		case "menlegnon":
			if($extra['menleg']=="non"){echo "checked";}
			else{echo " ";};
			break;

		case "agendaoui":
			if($extra['agenda']=="oui"){echo "checked";}
			else{echo " ";};
			break;
		case "agendanon":
			if($extra['agenda']=="non"){echo "checked";}
			else{echo " ";};
			break;

		case "blogoui":
			if($extra['blog']=="oui"){echo "checked";}
			else{echo " ";};
			break;
		case "blognon":
			if($extra['blog']=="non"){echo "checked";}
			else{echo " ";};
			break;

		case "forumoui":
			if($extra['forum']=="oui"){echo "checked";}
			else{echo " ";};
			break;
		case "forumnon":
			if($extra['forum']=="non"){echo "checked";}
			else{echo " ";};
			break;

		case "albumoui":
			if($extra['album']=="oui"){echo "checked";}
			else{echo " ";};
			break;
		case "albumnon":
			if($extra['album']=="non"){echo "checked";}
			else{echo " ";};
			break;
		case "menu1":
			if($extra['menu']=="1"){echo "checked";}
			else{echo " ";};
			break;
		case "menu2":
			if($extra['menu']=="2"){echo "checked";}
			else{echo " ";};
			break;	
		case "remplissantoui":
			if($extra['remplissant']!="non"){echo "checked";}
			else{echo " ";};
			break;
		case "remplissantnon":
			if($extra['remplissant']=="non"){echo "checked";}
			else{echo " ";};
			break;		
		case "tbandeauoui":
			if($extra['tbandeau']!="non"){echo "checked";}
			else{echo " ";};
			break;
		case "tbandeaunon":
			if($extra['tbandeau']=="non"){echo "checked";}
			else{echo " ";};
			break;
		
		default :	
			if(!$extra[$p]){$extra[$p]="#cccccc";echo $extra[$p];}
			else{ echo $extra[$p];};
		};
	

}
?>