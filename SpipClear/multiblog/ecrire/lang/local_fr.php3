<?php

// This is a SPIP language file  --  Ceci est un fichier langue de SPIP

$GLOBALS[$GLOBALS['idx_lang']] = array(


'multiblog_icone_information' => 'Informations n�cessaires pour la cr�ation du blog (un blog dans le cadre du script multiblog c\'est au sens SPIP : un secteur et un admin restreint) ',
'multiblog_entree_titre_obligatoire' => 'Titre du blog',
'multiblog_texte_descriptif_rapide' => 'Descriptif',
'multiblog_entree_contenu_rubrique' => '(ligne �ditorial du blog en quelques mots)',
'multiblog_nouveau_blog' => 'Nouveau blog',
'multiblog_entree_nouveau_passe' => 'Mot de passe',
'multiblog_info_creation_blog_ok' => 'cr�ation termin�e', 
'multiblog_aide' => '

MultiBlog

QUOI ? 
------------
Le MultiBlog vous permet de cr�er un ensemble de blogs � partir d\'un unique site SPIP.
Plusieurs blogs donc sur un m�me site SPIP. 
Une autre particularit� est de pouvoir choisir le \'look\' de son blog. En effet on utilise ici les themes des differents blog qui proposent leur design sous licence GPL.
A ce jour, les themes de Dotclear et Wordpress sont disponibles. 


COMMENT ? 
------------
Le MultiBlog se base sur du SPIP.
Chaque blog est un secteur (rubrique � la racine du site SPIP). 
Afin de publier ses billets chaque auteur d\'un blog est administrateur restreint de sa rubrique. 
Une page sp�ciale dans l\'espace priv�ee de votre site SPIP permet de faciliter la gestion de votre (ou vos) blogs.

INSTALLATION   
---------------
T�l�charger l\'archive MultiBlog.
1/
Si vous n\'avez pas de fichier ecrire/mes_options.php3 : allez le cr�er : il doit contenir les lignes suivantes : 
<?
$dossier_squelettes=\"multiblogtheme\";
?>
Si ce fichier existe et qu\'il ne contient pas de ligne avec dossier_squelettes : 
ajouter cette ligne : 
$dossier_squelettes=\"multiblogtheme\";

// A FINIR : Si vous avez d�ja un $dossier_squelettes d�fini dans le fichier et que vous voulez utiliser le multiblog :  


{{FAQ}} 

- {{Pour le script "multiblog", c\'est quoi un blog ?}}
-* Au sens SPIP, un blog c\'est un secteur administr� par un admin restreint. 

- {{Je veux cr�er 2 blogs dans ma "ferme" � blog mais je n\'y arrive pas }}
-* Normal : pas possible de recr�er 2 fois un m�me auteur. Il faut passer par la cr�ation classique d\'un secteur SPIP puis "administrer restrictivement" l\'auteur du blog sur ce secteur et enfin de choisir un th�me par l\'action liste du menu gauche  

- {{Comment installer un nouveau th�me ? }}
-* Balladez vous sur internet et cherchez le th�me qui vous plait. Tout d\'abord, par respect envers l\'auteur du th�me, v�rifiez la licence de ce th�me et donc que vous avez le droit de l\'utiliser. Pour Doclear et Wordpress, copiez juste le th�me dans le r�pertoire ad�quat (dotclear pour dotclear et wordpress pour wordpress). Simple non ?  

- {{La page liste de multiblog.php3 ne me donne pas la liste de tous les secteurs du site}}
-* Cette page liste tous les secteurs si vous �tes admin, mais seulement "vos" rubriques si vous �tes admin restreint 

- {{Puis je utiliser le "multiblog" juste pour choisir un th�me ? }}
-* Bien sur ... il n\'y a aucunne contre indication 


', 
'multiblog_info_liste' => 'Cette liste repr�sente la liste des secteurs du site SPIP courant (pas seulement les blogs) ... Utiliser cette page avec pr�cation .',
'multiblog_menu_aide' => 'multiblog ?'

);


?>
