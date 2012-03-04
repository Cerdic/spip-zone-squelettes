<?php
/*
 * va chercher sur Amazon et met le tout en cache
 */

function stef_debug($str) {
	$debug = true;
	
	if($debug) {
		echo $str;
	}
}

stef_debug("start");

/*
 * params 
 */
$local_file = "amazon_cache.html";
$filename = "http://www.amazon.fr/gp/registry/2VRTTG2B3O6QT";
$contents = "rien";
$delai_before_caching = 60 * 60 * 24; // one day

if( !file_exists($filename) || (time() - filemtime($local_file)) > $delai_before_caching ) {
		stef_debug("plus vieux que " . $delai_before_caching);
		
		if( $handle = fopen($filename, "r") ) {
			$contents = "";
			while (!feof($handle)) {
				$contents .= fgets($handle, 128);
			}
			fclose($handle);
		}
		
		if($contents!="rien") {
			$new = @fopen($local_file,"w+");
			if($new) {
				fwrite($new,$contents);
				fclose($new);
				stef_debug("ok");
			}
		}
	} else {
		stef_debug("moins vieux que " . $delai_before_caching);
	}

?>
