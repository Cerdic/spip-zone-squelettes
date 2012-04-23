<?php
	function squelette_leadescent_insertion_in_head($flux) {
	    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.jcarousel.js') . "\"></script>
	    ";
	    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/jquery.cycle.js') . "\"></script>
	    ";
	    $flux .= "<script type=\"text/javascript\" src=\"" . find_in_path('js/slider.js') . "\"></script>
	    ";
	    return $flux;	
	}
?>