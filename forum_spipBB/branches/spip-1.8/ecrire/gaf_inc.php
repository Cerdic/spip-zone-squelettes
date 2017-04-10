<?php
/*
+-------------------------------------------+
| GAFoSPIP - les fonctions
+-------------------------------------------+
| Gestion Alternative des Forums SPIP
| v. 0.1 - 10/08/05 - 2/09/05
+-------------------------------------------+
| Hugues AROUX - SCOTY @ koakidi.com
+-------------------------------------------+
*/

include_ecrire("inc_abstract_sql.php3");
include_ecrire('inc_filtres.php3');

# petit paramètrage laissé à votre discrétion :
# fixer le nombre de ligne des tableaux (-> tranches), dans Forums et Sujets.
if (!$GLOBALS['fixlimit'])
	{ $GLOBALS['fixlimit']=10; }

# Trouve et fixe l'id du mot 'rub_gaforum' 
# appliqué au(x) Secteur(s) forums
if (!$GLOBALS['id_mot_rub_gaf'])
	{
	$res = spip_query("SELECT id_mot FROM spip_mots WHERE titre='rub_gaforum'");
	$row = spip_fetch_array($res);
	$GLOBALS['id_mot_rub_gaf'] = $row['id_mot'];
	}
# trouve fixe l'id du mot 'Fermé'
# appliqué par SPIPForum (spip vs phpbb) sur article
if (!$GLOBALS['id_mot_art_ferme'])
	{
	$res = spip_query("SELECT id_mot FROM spip_mots WHERE titre='Fermé'");
	$row = spip_fetch_array($res);
	$GLOBALS['id_mot_art_ferme'] = $row['id_mot'];
	}
# trouve fixe l'id du mot 'annonce'
# appliqué par SPIPForum (spip vs phpbb) sur sujet
if (!$GLOBALS['id_mot_annonce'])
	{
	$res = spip_query("SELECT id_mot FROM spip_mots WHERE titre='annonce'");
	$row = spip_fetch_array($res);
	$GLOBALS['id_mot_annonce'] = $row['id_mot'];
	}


//
$gaf_version="0.1";
//


//
// diver bloc et boutons
//
function debut_bloc_couleur($coul_bloc)
	{
	echo "<div style=' background-color:$coul_bloc;  padding:1px 3px 2px 1px;
			border-top:1px solid #000000; -moz-border-radius:7px;'>\n";
	}

function debut_bloc_gricont()
	{
	global $couleur_foncee;
	echo "<div style='padding:2px; background-color:#efefef; 
			border:2px solid $couleur_foncee; -moz-border-radius:5px; 
			text-align:center;'>\n";
	}
function debut_ligne_foncee($retrait)
	{
	global $couleur_foncee;
	echo "<div style='background-color:".$couleur_foncee."; padding:3px;
			margin-left:".$retrait."px; -moz-border-radius:7px; 
			color:#ffffff;' class='verdana3'>\n";	
	}
	
function debut_ligne_claire($retrait)
	{
	global $couleur_claire;
	echo "<div style='background-color:".$couleur_claire."; padding:3px;
			margin-left:".$retrait."px; -moz-border-radius:7px;' class='verdana3'>\n";	
	}

function debut_ligne_grise($retrait)
	{
	echo "<div style='background-color:#efefef; padding:3px;
			margin-left:".$retrait."px; -moz-border-radius:7px;' class='verdana3'>\n";	
	}


function fin_bloc() { echo "</div>\n"; }

function bloc_art_ferme($type_ferme)
	{
	if ($type_ferme=="ferme")
		{ echo "<img src='"._DIR_IMG_PACK."gaf_verrou1.gif' align='absmiddle' border='0' hspace='3'>"; }
	if ($type_ferme=="mainten")
		{
		echo "<div class='verdana3' style='padding:2px; color:#ED4242;'>";
		echo "<img src='"._DIR_IMG_PACK."gaf_verrou2.gif' align='absmiddle' border='0' hspace='3'>";
		echo _T('phpbb:maintenance_ferme');
		echo "</div>";
		}
	}

function signature_gaf()
	{
	global $gaf_version;
		echo "<br>";
	debut_boite_info();
		echo "<b>"._T('phpbb:credits_bis1').$gaf_version."</b><br>";
		echo "<a href='http://www.koakidi.com/'>Scoty, koakidi.com.</a><br>"._T('phpbb:credits_bis2')."<br><br>";
		echo _T('phpbb:credits_bis3');
		echo "<a href='https://contrib.spip.net/Un-squelette-de-forum-8-4-CSS'>SPIP Forum</a><br>";
		echo _T('phpbb:credits_bis4');
	fin_boite_info();
	}


//
// bouton popup ecrire post
function bouton_ecrire_post($id_article, $id_sujet)
{
if ($id_sujet)
	{ $icone="gaf_post.gif"; $texte_icone=_T('phpbb:repondre'); }
else
	{ $icone="gaf_sujet.gif"; $texte_icone=_T('phpbb:sujet_nouveau'); }
	
	echo "
	<div style='float:right; margin-left:3px;' title='$texte_icone' class='icone36' >\n
	<a href=\"gaf_formpost.php?forum=$id_article&sujet=$id_sujet\" 
	target=\"redige_post\" 
	onclick=\"javascript:window.open(this.href, 'redige_post', 
	'width=650, height=550, menubar=no, scrollbars=yes'); return false;\"\n>
	<img src='"._DIR_IMG_PACK."creer.gif' align='absmiddle' border='0'
	style='background-image:url(\""._DIR_IMG_PACK.$icone."\"); background-repeat:no-repeat; 
		background-position:center;' width='24' height='24'\n>
	</a>
	</div>\n";
}


//
// pose l'icone annonce, si sujet est une "annonce" (oh)
function verif_sujet_annonce($id_sujet)
{
$req=spip_query("SELECT id_forum FROM spip_mots_forum WHERE id_mot=".$GLOBALS['id_mot_annonce']." AND id_forum=$id_sujet");
$res=spip_num_rows($req);
if($res)
	{ $aff_a = "<div style='float:right; padding-right:3px;' title='"._T('phpbb:sujet_annonce')."'>
					<img src='"._DIR_IMG_PACK."gaf_annonce.gif'></div>";
	return $aff_a; }	
}


//
// Fixe l'icone du statut d'un post
function icone_statut_post($statut_post)
	{
		// icone état du post
		switch ($statut_post) {
		case"off":
		$aff_statut = "<div style='float:right;' title='"._T('phpbb:sujet_rejete')."'>
					<img src='"._DIR_IMG_PACK."gaf_p_off.gif'></div>";
		break;
		case"prop":
		$aff_statut = "<div style='float:right;' title='"._T('phpbb:sujet_valide')."'>
					<img src='"._DIR_IMG_PACK."gaf_p_prop.gif'></div>";
		break;
		case"publie":
		$aff_statut = "";
		break;
		default:
			return;
		}
	return $aff_statut;
	}




//
// tranches ... pagination
//
function tranches_liste_forum($encours, $retour_gaf)
	{
	global $page, $nligne, $fixlimit;
	$fract=ceil($nligne/$fixlimit);
	for ($i=0; $i<$fract; $i++)
		{
		$debaff=($i*$fixlimit)+1;
		$f_aff=($i*$fixlimit)+$fixlimit;
		$liais=$i*$fixlimit;
		if ($f_aff<$nligne) { $finaff=$f_aff; $sep = " | "; }
		else { $finaff=$nligne; $sep = ""; }
		if ($debaff==$encours)
			{
			echo "<b>$debaff - $finaff</b> $sep\n";}
		else
			{
			echo "<a href='".$retour_gaf."&vl=$liais'>$debaff - $finaff</a> $sep\n";
			}
		}
	}



//
// url dernier post dans la bonne tranche
// 
function url_post_tranche($id_post, $id_sujet, $compt_rang="")
{
global $fixlimit;

if ($compt_rang)
	{
	$val_vl=$fixlimit*(ceil($compt_rang/$fixlimit)-1);
	$url_post = "gaf_admin.php?page=sujet&id_sujet=$id_sujet&vl=$val_vl#$id_post";
	}

if ($id_post==$id_sujet)
	{ $url_post = "gaf_admin.php?page=sujet&id_sujet=$id_sujet"; }
else
	{
	$nbr_id=spip_num_rows(spip_query("SELECT id_forum FROM spip_forum WHERE id_thread=$id_sujet"));
	if ($nbr_id<$fixlimit)
		{ $url_post = "gaf_admin.php?page=sujet&id_sujet=$id_sujet#$id_post"; }
	else
		{
		$val_vl=$fixlimit*(floor($nbr_id/$fixlimit));
		$url_post = "gaf_admin.php?page=sujet&id_sujet=$id_sujet&vl=$val_vl#$id_post";
		}
	}
return $url_post;
}


//
// cet article est-il fermé, fermé maintenance ?
//
function verif_article_ferme($id_article)
{
	$art_ferm = $GLOBALS['id_mot_art_ferme'];
	$req="SELECT * FROM spip_mots_articles WHERE id_mot=$art_ferm AND id_article=$id_article";
	$res=spip_query($req);
	$row=spip_num_rows($res);
	if ($row) {
		$rf ="ferme";
		if ($ds = @opendir(_DIR_SESSIONS)) {
			while (($file = @readdir($ds)) !== false) {
				if (preg_match('/^gafart_([0-9]+)-([0-9]+)\.lck$/', $file, $match)) {
					if($match[1] == $id_article)
						{ $rf ="mainten"; }
				}
			}
		}
	}
return $rf;
}


//
// Avis de lock pour maintenance
//
function alerte_maintenance()
	{
	if ($ds = @opendir(_DIR_SESSIONS))
		{
		while (($file = @readdir($ds)) !== false)
			{
			if (preg_match('/^gafart_([0-9]+)-([0-9]+)\.lck$/', $file, $match))
				{
				$datime=date("d/m/y H:i",@filemtime(_DIR_SESSIONS.$file));
				$art_mt=$match[1];
				$aut_mt=$match[2];
				$req=spip_query("SELECT nom FROM spip_auteurs WHERE id_auteur=$aut_mt");
				$row=spip_fetch_array($req);
				$req2=spip_query("SELECT titre FROM spip_articles WHERE id_article=$art_mt");
				$row2=spip_fetch_array($req2);
				debut_cadre_couleur();
				echo "<div class='verdana3'><b>".$row['nom']."</b></div>\n".
				"<div class='verdana2'>"._T('phpbb:admfermer')."<br>\n".
				"<b>".$row2['titre']._T('phpbb:pour_maintenance').$datime."</div>\n";
				fin_cadre_couleur();
				}
			}
		}
	}


//
// autorité GAF pour un déplacement
//
function auth_deplace_connecte()
	{
	$id_auth = $GLOBALS['auteur_session']['id_auteur'];
	if ($dh = @opendir(_DIR_SESSIONS))
		while (($file = @readdir($dh)) !== false)
				if (preg_match('/^gafart_([0-9]+)-([0-9]+)\.lck$/', $file, $match))
					if ($match[2] == $id_auth)
						return true;
	}

//
// bouton deplace thread
function bouton_deplace_sujet($id_forum, $id_sujet)
	{
	$id_auth = $GLOBALS['auteur_session']['id_auteur'];
	$file="gafart_$id_forum-$id_auth.lck";
	if(@file_exists(_DIR_SESSIONS.$file)
		AND (time()-@filemtime(_DIR_SESSIONS.$file) > 600 ))// 10 minutes avant deplacement
		{
		echo "<div style='padding:3px;'>";
		echo "<form action='gaf_admin.php?page=affect' method='post'>";
		echo "<input type='hidden' name='id_article' value='".$id_forum."'>";
		echo "<input type='hidden' name='id_sujet' value='".$id_sujet."'>";
		echo "<input type='image' src='"._DIR_IMG_PACK."naviguer-site.png' border='0' title='"._T('phpbb:fil_deplace')."'>";
		echo "</form></div>";
		}
	}




//
// hierarchie sur élément unique
//
function aff_parents($id_rubrique, $id_article, $parents="")
	{
	global $couleur_foncee, $spip_lang_left, $lang_dir;

	if ($id_article)
		{
		$result=spip_query("SELECT id_article, id_rubrique, titre 
							FROM spip_articles 
							WHERE id_article=$id_article");
		while($row = spip_fetch_array($result))
			{
			$id_article = $row['id_article'];
			$id_rubrique = $row['id_rubrique'];
			$titre = $row['titre'];
			$logo = "gaf_forum-12.gif";
			
			$parents = "<div class='verdana3' ". 
			  http_style_background($logo, "$spip_lang_left center no-repeat; padding-$spip_lang_left: 25px"). 
			  "><a href='gaf_admin.php?page=forum&id_article=$id_article'>".typo($titre)."</a></div>\n<div style='margin-$spip_lang_left: 3px;'>".$parents."</div>";
			}
		aff_parents($id_rubrique, $id_article="", $parents);
		}
	else if ($id_rubrique)
		{
		$query = "SELECT id_rubrique, id_parent, titre, lang FROM spip_rubriques WHERE id_rubrique=$id_rubrique";
		$result = spip_query($query);

		while ($row = spip_fetch_array($result)) {
			$id_rubrique = $row['id_rubrique'];
			$id_parent = $row['id_parent'];
			$titre = $row['titre'];
			changer_typo($row['lang']);

			if (acces_restreint_rubrique($id_rubrique))
				$logo = "admin-12.gif";
			if (!$id_parent)
				$logo = "gaf_hall-12.gif";
			else
				$logo = "gaf_salon-12.gif";


			$parents = "<div class='verdana3' ". 
			  http_style_background($logo, "$spip_lang_left center no-repeat; padding-$spip_lang_left: 25px"). 
			  "><a href='gaf_admin.php?rub_act=$id_rubrique'>".typo($titre)."</a></div>\n<div style='margin-$spip_lang_left: 3px;'>".$parents."</div>";
			}
		aff_parents($id_parent, '', $parents);
		}
	else
		{
		$logo = "gaf_hall-12.gif";
		$parents = "<div class='verdana3' " .
		  http_style_background($logo, "$spip_lang_left center no-repeat; padding-$spip_lang_left: 25px"). 
		  "><a href='gaf_admin.php'><b>"._T('phpbb:secteur_forum')."</b></a></div>\n<div style='margin-$spip_lang_left: 3px;'>".$parents."</div>";
	
		echo $parents;
		}
	}
//


//
// les pitis articles de grand_ma rubrique
//
function bb_article($id_rubrique, $rang_rub)
{
global $couleur_claire, $art_act;

$reqa=spip_query("SELECT id_article, id_rubrique, titre FROM spip_articles WHERE id_rubrique=$id_rubrique");
$nbr_rep=spip_num_rows($reqa);
if($nbr_rep > 0)
	{
	while ($row=spip_fetch_array($reqa))
		{
		$id_article=$row['id_article'];
		$id_rubrique=$row['id_rubrique'];
		$titre=$row['titre'];
		$retrait = 35*$rang_rub;
		debut_ligne_grise($retrait);
		if($id_article == $art_act)
			{
			echo "<div style='float:right; padding:3px; text-align:right; 
					border:2px solid ".$couleur_claire."; -moz-border-radius:5px;'>\n";
			echo "<img src='"._DIR_IMG_PACK."puce-blanche.gif' align='absmiddle'>";
			echo "</div>\n";
			}
		else
			{
			echo "<div style='float:right; padding:3px; text-align:right; 
					border:2px solid ".$couleur_claire."; -moz-border-radius:5px;'>\n";
			echo "<input type='radio' name='id_art_new' value='".$id_article."'>";
			echo "</div>\n";			
			}
		echo "<img src='"._DIR_IMG_PACK."gaf_forum.gif' align='absmiddle'>\n 
			<span class='verdana2'>".$id_article."</span> - <b>".propre($titre)."</b>\n";
		echo "<input type='hidden' name='titre_new' value='".typo($titre)."'>";
		fin_bloc();
		}
	echo "<div align='right'><input type='submit' value='"._T('spip:bouton_valider')."' class='fondo'></div>\n";
	}
}

//
// grand_ma et ses pitis
//
function grand_ma($id_rubrique, $rang_rub)
{
$req=spip_query("SELECT id_rubrique, titre FROM spip_rubriques WHERE id_parent=$id_rubrique");
while ($row=spip_fetch_array($req))
	{
	$id_rubrique=$row['id_rubrique'];
	$titre=$row['titre'];
	$rang_rub++;
	$retrait = 20*$rang_rub;
	debut_ligne_claire($retrait);
	echo "<img src='"._DIR_IMG_PACK."gaf_salon.gif' align='absmiddle'> 
		<span class='verdana2'>".$id_rubrique."</span> - <b>".propre($titre)."</b>\n";
	fin_bloc();

	bb_article($id_rubrique, $rang_rub);
	grand_ma($id_rubrique, $rang_rub);
	}
}



//
// Tous sur la Gestion  Redaction sujet, message. 
// Popup. Formulaire .
//


// adaptation de la fonction 'smileys'
// d'après BoOz (booz.bloog@laposte.net)
//
function genere_list_smileys()
	{
	$listimag=array();
	$rep1="../smileys/";
	$listfich=opendir($rep1);
	while ($fich=readdir($listfich))
		{
		if(($fich !='..') and ($fich !='.') and ($fich !='.test'))
			{ 
			$nomfich=substr($fich,0,strrpos($fich, "."));
			$listimag[$nomfich]=$rep1.$fich;
			} // "<img alt='smiley' src='".$rep1.$fich."' border='0' title='".$nomfich."'>"
		}
	ksort($listimag);
	reset($listimag);
	return $listimag;
	}

//
// filtre
function smileys_in_texte($chaine)
	{
	$listimag = genere_list_smileys();
	while (list($nom,$chem) = each($listimag))
		{
		$smil_html = "<img alt='smiley' src='".$chem."' border='0' title='".$nom."'>";
		$chaine = str_replace(":".$nom, $smil_html , $chaine);
		}
	return $chaine;
	}

//
// Le tableau de smileys, pour le formulaire
function tableau_smileys()
	{
	$listimag = genere_list_smileys();
	// nombre de colonnes (2 par défaut) (pas trop large pour GAF ! !!)
	$nbcol=2;
	$compte=0;
	echo "<table width='100%' cellspacing='0' cellpadding='1' border='0'><tr>\n";
	while (list($nom,$chem) = each($listimag))
		{ 
		echo "<td valign='bottom' class='verdana1'><div align='center'>
		<a href=\"javascript:emoticon(':".$nom."')\">
		<img src='".$chem."' border='0' title='smileys - \" :".$nom." \"'></a>
		</div></td>\n";
		
		$compte++; 
		if ($compte % $nbcol == 0)
			{ echo"</tr><tr>\n"; }
		}
	echo "</tr></table>";
	}



// la barre de typo dupiquée pour l'occas'
//
function barre_forum_ingaf($texte)
{
	include_ecrire('inc_layer.php3');

	if (!$GLOBALS['browser_barre'])
		return "<textarea name='texte' rows='12' class='forml' cols='40'>".$texte."</textarea>";
	static $num_formulaire = 0;
	$num_formulaire++;
	include_ecrire('inc_barre.php3');
	return afficher_barre("document.getElementById('formulaire_$num_formulaire')", true) .
	"
	<textarea name='texte' rows='12' class='forml' cols='40' 
	id='formulaire_$num_formulaire' 
	onselect='storeCaret(this);' 
	onclick='storeCaret(this);' 
	onkeyup='storeCaret(this);' 
	ondbclick='storeCaret(this);'>".$texte."</textarea>";
}



// reprise de la fonction (issue de inc_messforum.php3)
// à modifier pour gafospip ... : ajout argument $id_thread ;
//
function mail_auteurs($auteur, $email_auteur, $id_forum, $id_thread, $id_article, $texte, $titre, $statut) {
	global $nom_site_forum, $url_site;
	include('inc_texte.php3'); // on est dans ecrire : include'
/*	include_ecrire('inc_filtres.php3'); // déjà inclus*/
	include('inc_mail.php3'); // on est dans ecrire : include'
	// Gestionnaire d'URLs
	if (@file_exists("inc-urls.php3"))
		include_local("inc-urls.php3");
	else
		include_local("inc-urls-".$GLOBALS['type_urls'].".php3");

	if ($statut == 'prop') # forum modere
		/*$url = "ecrire/controle_forum.php3?debut_id_forum=$id_forum";*/
		$url = "ecrire/gaf_admin.php?page=sujet&id_sujet=$id_thread#$id_forum";
	else if (function_exists('generer_url_forum'))
		$url = generer_url_forum($id_forum);
	else {
		spip_log('inc-urls personnalise : ajoutez generer_url_forum() !');
		$url = generer_url_article($id_article);
	}

	$adresse_site = lire_meta("adresse_site");
	$url = $adresse_site .'/' .  ereg_replace('^/', '', $url);

	$sujet = "[" .
	  entites_html(textebrut(typo(lire_meta("nom_site")))) .
	  "] ["._T('forum_forum')."] $titre";

	$parauteur = (strlen($auteur) <= 2) ? '' :
	  (" " ._T('forum_par_auteur', array('auteur' => $auteur)) . 
	   ($email_auteur ? "" : (' <' . $email_auteur . '>')));

	$corps = _T('form_forum_message_auto') .
		"\n\n" .
		_T('forum_poste_par', array('parauteur' => $parauteur)).
		"\n"
	  	. _T('forum_ne_repondez_pas')
	  	. "\n"
		. $url
		. "\n\n\n".$titre."\n\n".textebrut(propre($texte))
		. "\n\n$nom_site_forum\n$url_site\n";

	$old_lang = $GLOBALS['spip_lang'];

	$result = spip_query("SELECT auteurs.email, auteurs.lang FROM spip_auteurs AS auteurs,
				spip_auteurs_articles AS lien
				WHERE lien.id_article='$id_article'
				AND auteurs.id_auteur=lien.id_auteur");
	while (list($email, $salangue) = spip_fetch_array($result)) {
		$email = trim($email);
		if (strlen($email) < 3) continue;
		$GLOBALS['spip_lang'] = ($salangue ? $salangue : $old_lang);
		envoyer_mail($email, $sujet, $corps) ;
	}
	$GLOBALS['spip_lang'] = $old_lang;	
}




// Affiche le forumlaire de redac de post
//
function affiche_form_post()
{
global 	$previsu, $forum, $sujet, 
		$nom_site_forum, $url_site, $texte, $titre,
		$couleur_claire;

if(!$sujet) $sujet='0';

if($forum && $sujet=='0')
		{
		$res=spip_query("SELECT titre FROM spip_articles WHERE id_article=$forum");
		$row=spip_fetch_array($res);
		$titre_forum = $row['titre'];
		$text_intro = _T('phpbb:sujet_ajout').$titre_forum;
		}
else
		{
		$res=spip_query("SELECT titre FROM spip_forum WHERE id_forum=$sujet");
		$row=spip_fetch_array($res);
		$titre_sujet = $row['titre'];
		$text_intro = _T('phpbb:texte_repondre').$titre_sujet;
		}

	// auteur (bloque sur sessions -> pas de modif !!)
	$auteur = $GLOBALS['auteur_session']['nom'];
	$email_auteur = $GLOBALS['auteur_session']['email'];
	$id_auteur = $GLOBALS['auteur_session']['id_auteur'];

if($previsu=='1')
	{
	// trop court ? trop long ouaih !
	if ((strlen($texte) + strlen($titre) + strlen($nom_site_forum) +
		strlen($url_site) + strlen($auteur) + strlen($email_auteur)) > 20 * 1024)
		{ $verrou_ed='oui'; $affiche_texte = "<span style='color:#DD4C5A; font-size:13px;'>"._T('forum_message_trop_long')."</span>"; }
	else if (strlen($texte) < 10 )
		{ $verrou_ed='oui'; $affiche_texte = "<span style='color:#DD4C5A; font-size:13px;'>"._T('forum_attention_dix_caracteres')."</span>"; }
	else if (strlen($titre) < 3 )
		{ $verrou_ed='oui'; $affiche_texte = "<span style='color:#DD4C5A; font-size:13px;'>"._T('forum_attention_trois_caracteres')."</span>"; }
	else { $affiche_texte = propre($texte); }
	}

	
echo "\n<form action='gaf_formpost.php' method='post' name='formulaire'";

if($previsu=='1' && !$verrou_ed)
	{
	if($sujet!='0')
		{ $retour_post = "gaf_admin.php?page=sujet&id_sujet=$sujet"; }
	else
		{ $retour_post = "gaf_admin.php?page=forum&id_article=$forum"; }

	echo "onSubmit='window.opener.location.href=\"".$retour_post."\"; return(true)'";
	}

echo ">";


if($previsu=='1')
	{
	// Une securite qui nous protege contre :
	// ... ( ... ) ... voir formulaires/inc-forumlaire_forum.php3
	//
	// Le lock est leve au moment de l'insertion en base .. function enregistre_post_gaf
	
		$alea = preg_replace('/[^0-9]/', '', $alea);
		if(!$alea OR !@file_exists(_DIR_SESSIONS."forum_$alea.lck")) {
			while (
				# astuce : mt_rand pour autoriser les hits simultanes
				$alea = time() + @mt_rand()
				AND @file_exists($f = _DIR_SESSIONS."forum_$alea.lck")) {};
			spip_touch ($f);
		}

		# et maintenant on purge les locks de forums ouverts depuis > 4 h
		if ($dh = @opendir(_DIR_SESSIONS))
			while (($file = @readdir($dh)) !== false)
				if (preg_match('/^forum_([0-9]+)\.lck$/', $file)
				AND (time()-@filemtime(_DIR_SESSIONS.$file) > 4*3600))
					@unlink(_DIR_SESSIONS.$file);
	
	// hash gaf
		if(!$hash)
			$hash = calculer_action_auteur("ajout_forum $forum $sujet $alea");
	
	if($sujet!='0')
		{ $ico_post="gaf_post.gif"; }
	else
		{ $ico_post="gaf_sujet.gif"; }
	
	// supprimer les <form> de la previsualisation
	// (sinon on ne peut pas faire <cadre>...</cadre> dans les forums) .. code dégueu plutot !
	$affiche_texte = preg_replace("@<(/?)f(orm[>[:space:]])@ism", "<\\1no-f\\2", $affiche_texte);
	
	// affichage du prévisu
	$avant_post="
		<span class='verdana3'><b>"._T('phpbb:messages_verifier')."</b></span><br/><br/><span class='verdana2'> 
		<table cellpadding='3' cellspacing='1' border='0' width='100%'>
		<tr width='100%' bgcolor='".$couleur_claire."'>
		<td width='5%'valign='top'>
		<img src='"._DIR_IMG_PACK.$ico_post."' border='0'><br>
		</td>
		<td width='75%' valign='top'>
		<span class='verdana3'><b>".propre($titre)."</b></span><br>
		<span class='verdana2'><b>".$auteur."</b></span><br>
		</td><td width='20%' valign='top'>
		</td></tr><tr bgcolor='".$couleur_claire."'>
		<td colspan='3' valign='top'>
		<span class='verdana3'>".smileys_in_texte($affiche_texte)."</span>";
		if ($nom_site_forum)
			{ $avant_post.="
			<div align='right' class='verdana2'><br>- - - - -<br>
			<b><a href='".$url_site."'>".$nom_site_forum."</a></b></div>";
			}
	$avant_post.="
		</div>
		</td></tr>
		</table></span>\n
		<input type='hidden' name='hash' value='".$hash."' />\n
		<input type='hidden' name='alea' value='".$alea."' />\n
		";
	
		if ($verrou_ed!='oui')
		{ $avant_post.="
			<div align='right'>
			<input type='submit' name='valid_post' value='"._T('forum_message_definitif')."' class='fondo' />\n
			</div>\n"; }

	echo $avant_post;
	}


// formulaire
$form_post="
	<div style='padding:5px;' class='verdana3'><b>".$text_intro."</b></div><br/>

	<div class='verdana2' style='margin-left:100px;'>";

	echo "<div style='float:left; width:90px; padding:160px 2px 0px 2px;'>";
	debut_cadre_relief("");
		tableau_smileys();
	fin_cadre_relief();
	echo "</div>";

$form_post.="
	<fieldset><legend><b>"._T('forum_titre')."</b></legend>
		<label>
		<input type='text' name='titre' value='".propre($titre)."' class='forml' size='40' />
		</label>
	</fieldset><br />
	<fieldset><legend><b>"._T('forum_texte')."</b></legend>
		<p>"._T('info_creation_paragraphe')."</p>".
		barre_forum_ingaf($texte).
	"</fieldset><br />
	<fieldset><legend>"._T('forum_lien_hyper')."</legend>
		<p>"._T('forum_page_url')."</p>
		<p><label>"._T('forum_titre')."
		<input type='text' name='nom_site_forum' class='forml' size='40' value='".$nom_site_forum."' />
		</label></p>
		<p><label>"._T('forum_url')."
		<input type='text' name='url_site' class='forml' size='40' value='".($url_site ? $url_site : "http://")."' />
		</label></p>
	</fieldset><br />
	<fieldset><legend>"._T('forum_qui_etes_vous')."</legend>
		<p><label>"._T('forum_votre_nom')."
		<input type='text' name='auteur' value='".$auteur."' class='forml' size='40' />
		</label></p>
		<p><label>"._T('forum_votre_email')."
		<input type='text' name='email_auteur' value='".$email_auteur."' class='forml' size='40' />
		</label></p>
	</fieldset><br />
	
	<input type='hidden' name='previsu' value='1'>
	<input type='hidden' name='id_auteur' value='".$id_auteur."'>
	<input type='hidden' name='forum' value='".$forum."'>
	<input type='hidden' name='sujet' value='".$sujet."'>
	
	<div align='right'>
	<input type='submit' value='"._T('forum_voir_avant')."' class='fondo' />\n
	</div>\n
	
	</div>\n
	";

echo $form_post;
echo "</form>";
}



// Traiter et enregistrer le post
//
function enregistre_post_gaf()
{
global $REMOTE_ADDR, $_POST;

// Recuperer les donnees postees du formulaire
	foreach (array('auteur', 'email_auteur', 'id_auteur', 
		'nom_site_forum', 'url_site', 'texte', 'titre', 
		'alea', 'hash') as $item)
		{ $$item = $_POST[$item]; }

	foreach (array('forum', 'id_breve', 'id_syndic',
	'id_rubrique', 'sujet') as $id)
		if (isset($_POST[$id]))
			$$id = intval($_POST[$id]);
		else
			$$id = 0;


// voir ../inc-messforum.php3
	// Verifier hash securite
	include_ecrire("inc_admin.php3");
	if (!verifier_action_auteur("ajout_forum $forum $sujet $alea", $hash)) {
		spip_log('erreur hash forum');
		die (_T('forum_titre_erreur')); 	# echec du POST
	}
	// verifier fichier lock
	$alea = preg_replace('/[^0-9]/', '', $alea);
	if (!file_exists($hash = _DIR_SESSIONS."forum_$alea.lck"))
		return /*$retour_forum*/; # echec silencieux du POST
	unlink($hash);



// premier insert du message dans la base
	$id_message = spip_abstract_insert('spip_forum', '(date_heure)', '(NOW())');

	if ($sujet) {
		list($id_thread) = spip_fetch_array(spip_query(
		"SELECT id_thread FROM spip_forum WHERE id_forum = $sujet")); }
	else {
		$id_thread = $id_message; } # id_thread oblige INSERT puis UPDATE.

	$statut = ($statut == 'non') ? 'off' : (($statut == 'pri') ? 'prop' : 'publie');


// màj bdd
	spip_query("UPDATE spip_forum
	SET id_parent = $sujet,
	id_rubrique = $id_rubrique,
	id_article = $forum,
	id_breve = $id_breve,
	id_syndic = $id_syndic,
	id_auteur = $id_auteur,
	id_thread = $id_thread,
	date_heure = NOW(),
	titre = '".addslashes(corriger_caracteres($titre))."',
	texte = '".addslashes(corriger_caracteres($texte))."',
	nom_site = '".addslashes(corriger_caracteres($nom_site_forum))."',
	url_site = '".addslashes(corriger_caracteres($url_site))."',
	auteur = '".addslashes(corriger_caracteres($auteur))."',
	email_auteur = '".addslashes(corriger_caracteres($email_auteur))."',
	ip = '$REMOTE_ADDR',
	statut = '$statut'
	WHERE id_forum = $id_message
	");

	// Prevenir les auteurs de l'article, modifié gaf
	// faudrait vérifier le bon fonctionnement !!! // h. 2/10 ... mais ça à l'air d'etre ok !
	// -> fonction prevenir_auteur devenue : mail_auteur, pour gafospip (voir plus haut)
	//
	if (lire_meta("prevenir_auteurs") == "oui" AND ($afficher_texte != "non"))
		{
		mail_auteurs($auteur, $email_auteur, $id_message, $id_thread, $forum, $texte, $titre, $statut);
		}

	// INVALIDATION DES CACHES LIES AUX FORUMS, modifié gaf
	if ($statut == 'publie')
		{		
		include_ecrire('inc_invalideur.php3');
		suivre_invalideur ("id='id_forum/" .
		calcul_index_forum($forum, $id_breve, $id_rubrique, $id_syndic) . "'");
		}

}
//

?>