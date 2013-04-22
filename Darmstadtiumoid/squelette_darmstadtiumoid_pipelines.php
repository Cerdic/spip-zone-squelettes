<?php

function squelette_darmstadtiumoid_insertion_in_head($flux) {
	
	//print_r($GLOBALS["page"]["texte"])
	
    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.cycle.js') . "\"></script>
    ";
    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/slider.js') . "\"></script>
    ";
    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.superfish.js') . "\"></script>
    ";
    return $flux;
	
}

?>