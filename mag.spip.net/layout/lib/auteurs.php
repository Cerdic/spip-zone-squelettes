<?php

/* inc-auteurs.php3 - version 1.0.       */
/* derniere modification le 29 juin 2004 */
/* (c) Francois Schreuer GPL             */

/*
 * Fonction prenom_nom()
 *
 * Auteur : Fran�ois Schreuer <francois@schreuer.org>
 * http://francois.schreuer.org/
 *
 * Copyright : GNU Public Licence
 *
 * Si le nom ET le prenom sont pr�sents, on les renvoie concat�n�s et
 * s�par�s par un espace ins�cable, le nom �tant pass� en majuscules
 *
 * Dans le cas contraire (soit dans le cas ou au moins des deux �l�ments
 * est vide), on renvoie les deux d'un coup (et celui qui n'est pas vide
 * sera affiche). Et s'ils sont tous les deux vides, on renverra du vide,
 * comme il est de bon ton dans ce genre de situation.
 * 
 */
function prenom_nom($texte) {
	$texte = $texte;
	if(strstr(ereg_replace("^(@-|@-|@ |@|#-|#_|# |#)","",$texte),"*")) {
		if(prenom($texte) && nom($texte))
			return prenom($texte)."&nbsp;".strtoupper(nom($texte));
			# return prenom($texte)."&nbsp;".majuscules(nom($texte));
		else
			return prenom($texte).nom($texte);
	}
	else
		return $texte;
}

/*
 * Fonction prenom_nom()
 * 
 * Auteur : Fran�ois Schreuer <francois@schreuer.org>
 * http://francois.schreuer.org/
 * 
 * Copyright : GNU Public Licence
 * 
 * Cette fonction :
 * - enl�ve le signe distinctif des secretaires de redaction;
 * - renvoie le prenom apr�s l'avoir passe en minuscules et 
 *   avoir pass� l'initiale en majuscules.
 * 
 */
function prenom($texte) {
	$texte = $texte;
	$texte = ereg_replace("^(@-|@-|@ |@|#-|#_|# |#)","",$texte); // On commence par virer le signe distinctif d'un secr�taire de r�daction ou celui d'un traducteur
	if(strstr($texte,"*")) {
		if($prenom = trim(ereg_replace("(.*)\*(.*)","\\2",$texte))) {
			return harmonise_noms($prenom);
		}
		else {
			if(substr($texte,0,1) == "*")
				return harmonise_noms($texte);
			else
				return "";
		}
	}
	else
		return "";
}



/*
 * Fonction nom()
 * 
 * Auteur : Fran�ois Schreuer <francois@schreuer.org>
 * http://francois.schreuer.org/
 * 
 * Copyright : GNU Public Licence
 * 
 * Cette fonction :
 * - enl�ve le signe distinctif des secr�taires de r�daction;
 * - renvoie le nom apr�s l'avoir pass� en minuscules et 
 *   avoir pass� l'initiale en majuscules
 * 
 */
function nom($texte) {
	$texte = $texte;
	$texte = ereg_replace("^(@-|@-|@ |@|#-|#_|# |#)","",$texte); // On commence par virer le signe distinctif des secr�taires de r�daction
	if(strstr($texte,"*")) {
		if($nom = trim(ereg_replace("(.*)\*(.*)","\\1",$texte))) {
			return harmonise_noms($nom);
		}
		else {
			if(substr($texte,0,1) == "*")
				return "";
			else
				return harmonise_noms($texte);
		}
	}
	else {
		return $texte;
	}
}

/*
 * Fonction harmonise_noms()
 * 
 * Auteur : Fran�ois Schreuer <francois@schreuer.org>
 * 
 * Copyright : GNU Public Licence
 * 
 * Harmonise le format de l'affichage des noms.
 * 
 * Vous pouvez changer facilement le modele qui vous convient
 * en activant la ligne adequate.
 * 
 */
function harmonise_noms($texte) {

	// Passe tout en minuscule et met les initiales en majuscules

	return str_replace('&8217;','\'',ucwords_amelioree(strtolower(trim(str_replace("*"," ",str_replace("_"," ",$texte))))));

	// Ne fait rien
	// return trim($texte);

	// Passe tout en majuscules (avec la fonction idoine de SPIP)
	// return majuscules(trim($texte));

	// Met les initiales en majuscules
	// return ucwords_amelioree(trim($texte));

}


/*
 * Fonction ucwords_amelioree()
 *
 * Auteur : Fran�ois Schreuer <francois@schreuer.org>
 *
 * Copyright : GNU Public Licence
 *
 * Transforme la premi�re lettre de chaque mot (et de chaque
 * partie d'un mot compos�) d'une cha�ne en majuscule. Convertit
 * aussi les caract�res accentu�s.
 *
 * Par exemple, "jean-�dern hallier" devient "Jean-�dern Hallier"
 *
 */
function ucwords_amelioree($texte) {

	// On commence par les mots qui suivent un espace
	$tableau_1 = explode(" ",$texte);
    for($i=0;$i<sizeof($tableau_1);$i++) {
		$tableau_1[$i] = ucfirst_fr($tableau_1[$i]); }
	$texte = implode(" ",$tableau_1);
	
	// puis un espace ins�cable
	$tableau_2 = explode("&nbsp;",$texte);
    for($i=0;$i<sizeof($tableau_2);$i++) {
		$tableau_2[$i] = ucfirst_fr($tableau_2[$i]); }
	$texte = implode("&nbsp;",$tableau_2);

	// enfin un tiret
	$tableau_3 = explode("-",$texte);
    for($i=0;$i<sizeof($tableau_3);$i++) {
		$tableau_3[$i] = ucfirst_fr($tableau_3[$i]); }
	$texte = implode("-",$tableau_3);

	// Et on renvoie le tout
	return $texte;
}

/*
 * Fonction ucfirst_fr()
 *
 * Auteur : Fran�ois Schreuer <francois@schreuer.org>
 *
 * Copyright : GNU Public Licence
 *
 * Transforme la premi�re lettre d'une cha�ne en majuscule
 * en traitant aussi les caract�res accentu�s. Il s'agit
 * donc d'une version am�lior�e de ucfirst_fr()
 *
 * NB : Cette fonction a besoin de la fonction majuscules()
 * de SPIP
 *
 */
function ucfirst_fr($chaine) {
	return strtoupper(substr($chaine,0,1)).substr($chaine,1);
	# Version plus propre avec majuscules (probl�me en UTF-8)
	# return majuscules(substr($chaine,0,1)).substr($chaine,1);
}

/*
 * Autre �criture possible pour ucwords_amelioree() (nettement
 * plus jolie mais il faut encore impl�menter dedans le
 * traitement des caract�res fran�ais) :

function ucwords_amelioree($texte) {
����return ucwords(preg_replace_callback('`(\w+)(-)(\w+)`','mot_compose',$texte));
}

����// Sous-fonction de la pr�c�dente
����function mot_compose($match){
��������return $match[1].$match[2].ucfirst($match[3]);
����}

 *
 */

?>
