<?php

function ispip_insert_head($flux) {
	$flux .= '<script  src="'.find_in_path('ispip.js').'" type="text/javascript"></script>';
	return $flux;
}

?>