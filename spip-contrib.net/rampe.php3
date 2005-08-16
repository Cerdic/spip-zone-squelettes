<?php
$fond = "rampe";
$delais = 3600*24;

// cette ligne empeche l'affichage des boutons d'administration
$flag_preserver = true;

echo "
<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>
<rdf:RDF
  xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"
  xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
  xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"
  xmlns:admin=\"http://webns.net/mvcb/\"
  xmlns:cc=\"http://web.resource.org/cc/\"
  xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
  xmlns=\"http://purl.org/rss/1.0/\">

<channel rdf:about=\"http://www.spip-contrib.net/\">
  <title>SPIP-Contrib: Au feux</title>
  <description> SPIP-Contrib regroupe les utilisateurs qui veulent partager leurs trucs et astuces ... Et ils sont nombreux !
Dans la partie privée du site il y a de nombreuses contribs en attente de validation.
Les admins attirent plus particulièrement votre attention sur les contribs ci-dessous. Aidez-nous en les testant et en postant vos remarques sur le forum associé à l'article.
Merci.</description>
  <link>http://www.spip-contrib.net/</link>
  <dc:language>fr</dc:language>
  <dc:creator></dc:creator>

  <dc:rights></dc:rights>
    
</channel>
";




include ("inc-public.php3");
include("ecrire/inc_connect.php3");
  $id_mot=30;
	$sql= "SELECT article.titre,article.descriptif,article.id_article,article.texte,article.lang FROM spip_articles AS article, spip_mots_articles AS lien, spip_mots as mot ";
  $sql.=" WHERE lien.id_mot=$id_mot ";
  $sql.="       and lien.id_mot=mot.id_mot"; 
  $sql.="       and lien.id_article=article.id_article ";
  $sql.="       and   article.statut='prop'";
		$result = spip_query($sql);
		while ($row = spip_fetch_array($result)) {
			
      $id_article=$row['id_article'];
      $lang=$row['lang'];
      $titre=$row['titre'];
      $descriptif=$row['descriptif'];
      $texte=$row['texte'];
      
      echo "
      
      <item rdf:about=\"http://www.spip-contrib.net/ecrire/articles.php3?id_article=$id_article\">
  <title>$titre</title>
  <link>http://www.spip-contrib.net/ecrire/articles.php3?id_article=$id_article</link>
  <dc:date></dc:date>

  <dc:language>$lang</dc:language>
  <dc:creator></dc:creator>
  <dc:subject></dc:subject>
  <description>$descriptif</description>
  <content:encoded><![CDATA[]]></content:encoded>
</item>
";
      
      
      
  	}
echo "</rdf:RDF>";
?>
