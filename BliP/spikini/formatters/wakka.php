<?php

// This may look a bit strange, but all possible formatting tags have to be in a single regular expression for this to work correctly. Yup!

if (!function_exists("wakka2callback"))
{
	function wakka2callback($things)
	{
		$thing = $things[1];
        $result='';

		static $oldIndentLevel = 0;
		static $oldIndentLength= 0;
		static $indentClosers = array();
		static $newIndentSpace= array();
		static $br = 1;

		global $wiki;
	
		// Deleted 
                if ($thing == "@@")
                {
                        static $deleted = 0;
                        return (++$deleted % 2 ? "<span class=\"del\">" : "</span>");
                }
                // Inserted
                else if ($thing == "&pound;&pound;")
                {
                        static $inserted = 0;
                        return (++$inserted % 2 ? "<span class=\"add\">" : "</span>");
                }
		// escaped text
		else if (preg_match("/^\"\"(.*)\"\"$/s", $thing, $matches))
		{
			return $matches[1];
		}
		// raw inclusion from another wiki
		// (regexp documentation : see "forced link" below)
		else if (preg_match("/^\[\[\|(\S*)(\s+(.+))?\]\]$/", $thing, $matches))
		{
			list (,$url,,$text) = $matches;
			if (!$text) $text = "404";
			if ($url)
			{
    				$url.="/wakka.php?wiki=".$text."/raw";
				return $wiki->Format($wiki->Format($url, "raw"),"wakka");
			}
			else
			{
				return "";
			}
		}
		// forced links
		// \S : any character that is not a whitespace character
		// \s : any whitespace character
		else if (preg_match("/^\[\[(\S*)(\s+(.+))?\]\]$/", $thing, $matches))
		{
			list (, $url, , $text) = $matches;
			if ($url)
			{
				if ($url!=($url=(preg_replace("/@@|&pound;&pound;||\[\[/","",$url))))$result="</span>";
				if (!$text) $text = $url;
				$text=preg_replace("/@@|&pound;&pound;|\[\[/","",$text);
				return $result.$wiki->Link($url, "", $text);
			}
			else
			{
				return "";
			}
		}
		// events
		else if (preg_match("/^\(\((.*?)\)\)$/s", $thing, $matches))
		{
			if ($matches[1])
				return $wiki->Action($matches[1]);
			else
				return "{{}}";
		}
		// interwiki links!
                else if (preg_match("/^[A-Z][A-Z,a-z]+[:]([A-Z,a-z,0-9]*)$/s", $thing))

		{
			return $wiki->Link($thing);
		}
		// wiki links!
		else if (preg_match("/^[A-Z][a-z]+[A-Z,0-9][A-Z,a-z,0-9]*$/s", $thing))
		{
			return $wiki->Link($thing);
		}
		// if we reach this point, it must have been an accident.
		return $thing;
	}
}


//$text = str_replace("\r", "", $text);
//$text = chop($text)."\n";


function echappe_tags($letexte, $source) {
	$regexp_echap = "|<.*?".">|si";
	$les_echap = array();

	while (preg_match($regexp_echap, $letexte, $regs)) {
		$num_echap++;
		$les_echap[$num_echap] = $regs[0];
		$pos = strpos($letexte, $regs[0]);
		$letexte = substr($letexte,0,$pos)."@@SPIP_$source$num_echap@@"
			.substr($letexte,$pos+strlen($regs[0]));
	}

	return array($letexte, $les_echap);	
}

function avant_propre($letexte) {
	global $spikini_cache, $spikini_cache_file;
	static $n; #pour ne pas faire glob() a chaque Format (nettoyage du cache)
	$spikini_cache = $spikini_cache_file = false;

	if (function_exists('spip_file_get_contents')) {
		@mkdir ('CACHE/spikini');
		$spikini_cache_file = 'CACHE/spikini/'.md5($letexte).'.gz';
		if (file_exists($spikini_cache_file)) {
			$spikini_cache =
			# commenter la ligne ci-dessous si "cached" apparait (?)
			'<!-- cached -->'.
			spip_file_get_contents($spikini_cache_file);
			touch($spikini_cache_file); # encore utile

			// nettoyer un peu le cache spikini
			if (!$n
			AND $d = opendir('CACHE/spikini/')) {
				while (($f = readdir($d)) !== false)
					if (
					preg_match('/\.gz$/', $f)
					AND time()-@filemtime($f) > 24*3600
					AND $n++<100)
						@unlink($f);
			}
			return ''; # on va passer une chaine vide a propre()
		}
	}

	// proteger les liens Wiki etendus : [[MotWiki titre du lien]]
	$letexte = str_replace('[[', '[*[', $letexte);
	$letexte = str_replace(']]', ']*]', $letexte);
	return $letexte;
}

function apres_propre($letexte) {
	global $spikini_cache, $spikini_cache_file;

	# reinjecter le texte s'il etait dans le cache
	if ($spikini_cache !== false)
		$letexte = $spikini_cache;
	# sinon l'y enregistrer
	else if ($spikini_cache_file)
		ecrire_fichier($spikini_cache_file, $letexte);

	$letexte = str_replace('[*[', '[[', $letexte);
	$letexte = str_replace(']*]', ']]', $letexte);

	list($letexte, $les_echap) = echappe_tags($letexte, "SPIKINI");

	$letexte = preg_replace_callback(
	"/(\%\%.*?\%\%|".
	"\"\".*?\"\"|".
	"\[\[.*?\]\]|".
	"\b[a-z]+:\/\/\S+|".
	"\*\*|\#\#|&pound;&pound;|__|\/\/|".
	"======|=====|====|===|==|".
	"-{4,}|---|".
	"\n(\t+|([ ]{1})+)(-|[0-9,a-z,A-Z]+\))?|".
	"^(\t+|([ ]{1})+)(-|[0-9,a-z,A-Z]+\))?|".
	"\(\(.*?\)\)|".
        "\b[A-Z][A-Z,a-z]+[:]([A-Z,a-z,0-9]*)\b|".
	"\b([A-Z][a-z]+[A-Z,0-9][A-Z,a-z,0-9]*)\b|".
	"\n)/ms", "wakka2callback", $letexte);

	$letexte = echappe_retour($letexte, $les_echap, "SPIKINI");

	return $letexte;
}

?>
