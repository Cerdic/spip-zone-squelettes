<?php

#
# Voici un script qui permet de lire un "feed hAtom", et donc de
# verifier que notre page est conforme aux specs.
# Utilise la transformation XSLT hAtom2Atom de Luke Arno
# (a telecharger @ http://lukearno.com/projects/hAtom/hAtom2Atom.xsl )
#

include('ecrire/inc_version.php3');
include_ecrire('inc_sites');
include_ecrire('inc_distant');

#$url= 'http://blog.davidjanes.com/';
$url= 'http://members.optusnet.com.au/benjamincarlyle/benjamin/blog/';
#$url= 'http://blip.local/~fil/spip/';

$hAtom = recuperer_page($url);  ## same as file_get_contents()
ecrire_fichier('CACHE/atom.xml', $hAtom);  ## write_file

exec("tidy -asxhtml -numeric -o CACHE/atom-tidy.xml CACHE/atom.xml");

$xml = new DOMDocument;
$xml->load('CACHE/atom-tidy.xml');

## source XSL transform @ http://lukearno.com/projects/hAtom/hAtom2Atom.xsl
$xsl = new DOMDocument;
$xsl->load('hAtom2Atom.xsl');  

$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // attach xsl transform

$atom = $proc->transformToXml($xml);

echo "-------\n\n\n<hr><br>";  ## fool Safari's ugly feed: detector
var_dump($atom);

$content = analyser_backend($atom);  ## process rss backend

var_dump($content);

## print out processed data (title and url)
foreach ($content as $element) {
	echo $element['titre']."<br>".$element['url'].'<br/>';
}


?>