<?php
$f_pagination = find_in_path('pagination.php');
if($f_pagination) include_spip($f_pagination);

function google_like($string){
	$query = rtrim(str_replace("+", " ", $_GET['recherche']));  
	$qt = explode(" ", $query);
	$num = count ($qt);
	$cc = ceil(200 / $num);
		for ($i = 0; $i < $num; $i++) {
			$tab[$i] = preg_split("/($qt[$i])/i",$string,2, PREG_SPLIT_DELIM_CAPTURE);
			if(count($tab[$i])>1){
				$avant[$i] = substr($tab[$i][0],-$cc,$cc);
	    	    	        $apres[$i] = substr($tab[$i][2],0,$cc);
		    	        $string_re .= "<i>[...]</i> $avant[$i]<b>".$tab[$i][1]."</b>$apres[$i] <i>[...]</i> ";
	       }
	 }
	 return $string_re;
}


function balise_LESAUTEURS($p) {

	// Cherche le champ 'lesauteurs' dans la pile
	$_lesauteurs = champ_sql('lesauteurs', $p); 

	// Si le champ n'existe pas (cas de spip_articles), on donne la
	// construction speciale sql_auteurs(id_article) ;
	// dans le cas contraire on prend le champ 'les_auteurs' (cas de
	// spip_syndic_articles)
	if ($_lesauteurs AND $_lesauteurs != '$Pile[0][\'lesauteurs\']') {
		$p->code = $_lesauteurs;
	} else {
		$nom = $p->id_boucle;
	# On pourrait mieux faire qu'utiliser cette fonction assistante ?
		$p->code = "sql_auteurs2(" .
			champ_sql('id_article', $p) .
			",'" .
			$nom .
			"','" .
			$p->boucles[$nom]->type_requete .
			"','" .
			$p->boucles[$nom]->sql_serveur .
			"')";
	}

	$p->statut = 'html';
	return $p;
}

function sql_auteurs2($id_article, $table, $id_boucle, $serveur='') {
      $auteurs = "";
       if ($id_article) {
           $result_auteurs = spip_abstract_select(array('auteurs.nom', 'auteurs.id_auteur'),
               array('spip_auteurs AS auteurs',
                   'spip_auteurs_articles AS lien'), 
               array("lien.id_article=$id_article",
                   "auteurs.id_auteur=lien.id_auteur"),
               '',array(),'','',1, 
               $table, $id_boucle, $serveur);
   
           while($row_auteur = spip_abstract_fetch($result_auteurs, $serveur)) {
               $nom_auteur = typo($row_auteur["nom"]);
               $id_auteur = $row_auteur["id_auteur"];
             
                   $auteurs[] = "<a href=\"".generer_url_auteur($id_auteur)."\">$nom_auteur</a>";
             

           }
       }

	if($auteurs) {
	$last = array_pop($auteurs); 
	if ($auteurs) { return join($auteurs,', ').' y '.$last;	}else{ return $last; }
	}else{
	return ""; }


	
 }
?>
