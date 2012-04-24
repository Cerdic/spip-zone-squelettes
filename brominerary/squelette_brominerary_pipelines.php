<?php

function squelette_brominerary_insertion_in_head($flux) {
	
	//print_r($GLOBALS["page"]["texte"])
	    $flux .= "
			  <script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.nivo.js') . "\"></script>
			  <script type=\"text/javascript\" src=\"" . find_in_path('js/main.loading.js') . "\"></script>
    ";
    return $flux;
	
}

?>