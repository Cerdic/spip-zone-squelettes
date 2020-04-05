<?php

function squelette_californiumite_insert_head($flux) {
	
	
    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/jcarousellite.min.js') . "\"></script>
    ";
    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.cycle.js') . "\"></script>
    ";
    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.superfish.js') . "\"></script>
    ";
    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/sliders.js') . "\"></script>
    ";
    return $flux;
	
}

?>
