<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function html5up_phantom_hexa2rgba($color,$facteur){ 

	if ($color[0] == '#') {
		$color = substr($color, 1);
	}
	if (strlen($color) == 6) {
			list($r, $g, $b) = array($color[0].$color[1],$color[2].$color[3],$color[4].$color[5]);
		} elseif (strlen($color) == 3) {
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
	} else {
		return false;
	}
	$r = hexdec($r);
	$g = hexdec($g);
	$b = hexdec($b);

	$rgba = ('rgba('.$r.','.$g.','.$b.','.$facteur.')');
	
	return $rgba;

}
function hexa2utf8($color) {
	// %23585858%3B
	$color = str_replace('#','%23',$color);
	$color = $color.'%3B';
// 	$color = utf8_encode($color);
	return $color;
}