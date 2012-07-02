<?php

function squelette_rutherfordiumy_insertion_in_head($flux) {
	
	//print_r($GLOBALS["page"]["texte"])
	    $flux .= "
			  <script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.cycle.js') . "\"></script>
			  <script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.minicolor.js') . "\"></script>
			  <script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.superfish.js') . "\"></script>
			  <script type=\"text/javascript\" src=\"" . find_in_path('js/slider.js') . "\"></script>
	    ";
    return $flux;
	
}

?>