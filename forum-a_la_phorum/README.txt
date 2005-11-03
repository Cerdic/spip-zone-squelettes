Jeu de squelettes permettant de g�rer des squelettes arborescents de la m�me mani�re que le script Phorum

Exemple en ligne: http://sael.be/article31.html

Distribu� sous licence publique g�n�rale GNU/GPL

(c) 2005 Fran�ois Schreuer

Compatibilit� : SPIP 1.8.2

Installation :

1. copier tous les fichiers dans le r�pertoire racine d'un SPIP.

2. Remplacer la fonction generer_url_forum() par celle-ci dans le fichier inc-urls-...

function generer_url_forum($id_forum, $show_thread=false) {
	return "display_forum.php?id_forum=".$id_forum;
}

Fin de l'installation

-----------------------

PS: Si vous souhaitez utiliser RewriteMode, vous devez:

a) Ajouter la ligne suivante a votre fichier .htaccess

	RewriteRule ^forum([0-9]+).html$        display_forum.php?id_forum=$1 [QSA,L]

b) Remplacer la fonction generer_url_forum() par celle-ci dans le fichier inc-urls-...

function generer_url_forum($id_forum, $show_thread=false) {
	return "forum".$id_forum.".html";
}

