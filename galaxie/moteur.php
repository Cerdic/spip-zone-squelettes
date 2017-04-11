<?php
  /*********************\
   * moteur opensearch *
  \*********************/

  include("ecrire/inc_version.php3");
  include_ecrire("inc_filtres.php3");
  include_ecrire("inc_sites.php3");
  include_ecrire("inc_lang.php3");

  // langue demandee ?
  if ($l = $_GET['lang'])
    $critere_lang = "&lang=$l";
  else
    $critere_lang = "";

  //nos abonnes
  $sites = array(
    array("SPIP.NET","http://www.spip.net/opensearch.php?recherche={searchTerms}$critere_lang",10),
    array("FORUM.SPIP.ORG","http://forum.spip.org/opensearch.php?recherche={searchTerms}$critere_lang",10),
    /*array("SPIP-CONTRIB","https://contrib.spip.net/opensearch.php?recherche={searchTerms}",10),*/
    array("SPIP-CONTRIB","http://www.spip.net/contrib/opensearch.php?recherche={searchTerms}$critere_lang",10)
  );

  //$_GET["recherche"] = 'boucle';
 
	// lui passer une page opensearch, recuperee par exemple
	// comme resultat de
	// recuperer_page('http://www.spip.net/opensearch.php?recherche=boucle')
	function analyser_opensearch($page) {
		$resultats = array();
		if (preg_match_all('@<item[ >].*?</item>@ims', $page, $items, PREG_SET_ORDER)) {
			foreach ($items as $item) {
				$item = $item[0];
				unset($r);
				if (preg_match('@<title>(.*?)</title>@ims', $item, $regs))
					$r['title'] = filtrer_entites(supprimer_tags($regs[1]));
				if (preg_match('@<link>(.*?)</link>@ims', $item, $regs))
					$r['link'] = trim($regs[1]);
				if (preg_match('@<language>(.*?)</language>@ims', $item, $regs))
					$r['language'] = trim($regs[1]);
				if (preg_match('@<description>(.*?)</description>@ims', $item, $regs))
					$r['description'] =  filtrer_entites(supprimer_tags($regs[1]));

				if ($r) {
					$resultats[] = $r;
				}
			}
		}
		return $resultats;
	}

	// transformons un item
	function affiche_un_item ($item) {
    	        // ne pas afficher un resultat dans une lnague non souhaitee
                if ($_GET['lang'] !=''
                AND $item['language'] !=''
                AND $item['language'] <> $_GET['lang']) return;

		$text = "<br /><h3 class=\"spip\">@title@</h3>\n";
		$text.="\t<p>@description@</p>\n";
		$text.="<a class=\"spip_in\" href=\"@link@\" hreflang=\"@language@\">@linkc@</a> (@language@)";
		$text.="\n";

                $item['linkc'] = preg_replace(',[?&]var_recherche=.*,', '', $item['link']);
		foreach ($item as $name => $value)
			$text = str_replace ("@$name@", $value, $text);
		return $text;
	}

	function debut_page() {
		$debut = "<html><head><title>moteur experimental</title>";
		$debut.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$debut.="	<link href=\"screen.css\" rel=\"stylesheet\" type=\"text/css\" />";
		$debut.="	<style type=\"text/css\">@import url(\"spipstyle.css\");</style>";
		include ("squelettes/entete1.php3");

		$debut.="</head><body>";
		$debut.="		<div id=\"page\">";
		$debut.="				<div id=\"outercolonne\">";
		$debut.="				<div id=\"innercolonne\">";
		$debut.="				<div id=\"content\">";
		$debut.="				<div id=\"inside3col hollyfix\"> <p class=\"ie5bug\">&nbsp;</p>";
		

		$debut.="     <form method=\"GET\"><input type=\"texte\" value=\"" . entites_html($_GET['recherche']) . "\" name=\"recherche\"/><input type=\"submit\"/></form>";
		return $debut;
	}

	function fin_page() {
		return "</div></div></body></html>";
	}
	
	
	echo debut_page();
	if($_GET["recherche"]) {
		foreach ($sites as $url) {
			$nomUrl=$url[0];
			$lurl=$url[1];
			$nb=$url[2];
			

			// habillage spip-contrib
			echo"
			<div class=\"bloctype3 first\">
			<img class=\"borderTL2\" src=\"images/bloctype3/topleft.gif\" alt=\"\" width=\"5\" height=\"5\"/>
			<img class=\"borderTR2\" src=\"images/bloctype3/topright.gif\" alt=\"\" width=\"5\" height=\"5\"/>
			";
			
			
			// C'est ca qui est important 
			echo "	<p><h1>Recherche de <em>". entites_html($_GET["recherche"])."</em> sur <em>$nomUrl</em>... </h1>";

			// habillage spip-contrib
			echo"				<div class=\"spacer\">&nbsp;</div>
			</div>
			<div class=\"bottomCorners\">
			<img class=\"borderBL3\" src=\"images/bloctype3/bottomleft.gif\" alt=\"\" width=\"5\" height=\"5\" />
			<img class=\"borderBR3\" src=\"images/bloctype3/bottomright.gif\" alt=\"\" width=\"5\" height=\"5\"/>
			</div>
			";
			
			$lurl = str_replace("{searchTerms}", urlencode($_GET["recherche"]), $lurl);
			/*$page[$url] = analyser_opensearch(recuperer_page($url));*/
			//sans cache, sans tri
			foreach(analyser_opensearch(recuperer_page($lurl)) as $item) {
			  if (--$nb > 0)
    			    echo affiche_un_item($item);
                          $langues_vues[$item['language']] ++;
                        }
                        flush();

		}


                // Restriction a la langue truc
                $self = preg_replace(",&lang=.*,", "", $_SERVER['REQUEST_URI']);
                
		if ($_GET['lang']) {
		  echo "<hr /><li><a href=\"$self\">Recherche multilingue</a></li>\n";
		} else if (count($langues_vues)>1) {
                   echo "<hr />Restreindre a la langue :\n"; 
                   foreach ($langues_vues as $lang => $n)
                      echo "<li><a href=\"$self&lang=$lang\">".traduire_nom_langue($lang)."</a></li>\n";
                }

	}

	echo fin_page();
  
?>
