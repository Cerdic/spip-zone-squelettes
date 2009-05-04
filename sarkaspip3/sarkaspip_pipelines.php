<?php

function SarkaSpip_insert_head($flux){
	$flux .='<script src="'.url_absolue(find_in_path('scripts/menu_deroulant.js')).'" type="text/javascript"></script>';
	return $flux;
}
?>

