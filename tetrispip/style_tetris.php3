<?php
include("sq_conf.php3");

$fond = "style_tetris";
$delais = 3600;
$flag_preserver = true;
@header('Content-type: text/css;');

if(is_array($tetris)) {
	$_GET['xmax']=$tetris['xmax'];
	$_GET['ymax']=$tetris['ymax'];
	$_GET['xmarg']=$tetris['xmarg'];
	$_GET['ymarg']=$tetris['ymarg'];
	$_GET['xsize']=$tetris['xsize'];
	$_GET['ysize']=$tetris['ysize'];

	include ("inc-public.php3");
}
else return " ";
?>
