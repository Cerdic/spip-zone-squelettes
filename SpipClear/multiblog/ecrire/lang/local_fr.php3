<?php

// This is a SPIP language file  --  Ceci est un fichier langue de SPIP

$GLOBALS[$GLOBALS['idx_lang']] = array(


'multiblog_icone_information' => 'Informations nécessaires pour la création du blog (un blog dans le cadre du script multiblog c\'est au sens SPIP : un secteur et un admin restreint) ',
'multiblog_entree_titre_obligatoire' => 'Titre du blog',
'multiblog_texte_descriptif_rapide' => 'Descriptif',
'multiblog_entree_contenu_rubrique' => '(ligne éditorial du blog en quelques mots)',
'multiblog_nouveau_blog' => 'Nouveau blog',
'multiblog_entree_nouveau_passe' => 'Mot de passe',
'multiblog_info_creation_blog_ok' => 'création terminée', 
'multiblog_aide' => '

MultiBlog

QUOI ? 
------------
Le MultiBlog vous permet de créer un ensemble de blogs à partir d\'un unique site SPIP.
Plusieurs blogs donc sur un même site SPIP. 
Une autre particularité est de pouvoir choisir le \'look\' de son blog. En effet on utilise ici les themes des differents blog qui proposent leur design sous licence GPL.
A ce jour, les themes de Dotclear et Wordpress sont disponibles. 


COMMENT ? 
------------
Le MultiBlog se base sur du SPIP.
Chaque blog est un secteur (rubrique à la racine du site SPIP). 
Afin de publier ses billets chaque auteur d\'un blog est administrateur restreint de sa rubrique. 
Une page spéciale dans l\'espace privéee de votre site SPIP permet de faciliter la gestion de votre (ou vos) blogs.

INSTALLATION   
---------------
Télécharger l\'archive MultiBlog.
1/
Si vous n\'avez pas de fichier ecrire/mes_options.php3 : allez le créer : il doit contenir les lignes suivantes : 
<?
$dossier_squelettes=\"multiblogtheme\";
?>
Si ce fichier existe et qu\'il ne contient pas de ligne avec dossier_squelettes : 
ajouter cette ligne : 
$dossier_squelettes=\"multiblogtheme\";

// A FINIR : Si vous avez déja un $dossier_squelettes défini dans le fichier et que vous voulez utiliser le multiblog :  


{{FAQ}} 

- {{Pour le script "multiblog", c\'est quoi un blog ?}}
-* Au sens SPIP, un blog c\'est un secteur administré par un admin restreint. 

- {{Je veux créer 2 blogs dans ma "ferme" à blog mais je n\'y arrive pas }}
-* Normal : pas possible de recréer 2 fois un même auteur. Il faut passer par la création classique d\'un secteur SPIP puis "administrer restrictivement" l\'auteur du blog sur ce secteur et enfin de choisir un thème par l\'action liste du menu gauche  

- {{Comment installer un nouveau thème ? }}
-* Balladez vous sur internet et cherchez le thème qui vous plait. Tout d\'abord, par respect envers l\'auteur du thème, vérifiez la licence de ce thème et donc que vous avez le droit de l\'utiliser. Pour Doclear et Wordpress, copiez juste le thème dans le répertoire adéquat (dotclear pour dotclear et wordpress pour wordpress). Simple non ?  

- {{La page liste de multiblog.php3 ne me donne pas la liste de tous les secteurs du site}}
-* Cette page liste tous les secteurs si vous êtes admin, mais seulement "vos" rubriques si vous êtes admin restreint 

- {{Puis je utiliser le "multiblog" juste pour choisir un thème ? }}
-* Bien sur ... il n\'y a aucunne contre indication 


', 
'multiblog_info_liste' => 'Cette liste représente la liste des secteurs du site SPIP courant (pas seulement les blogs) ... Utiliser cette page avec précation .',
'multiblog_menu_aide' => 'multiblog ?'

);


?>
