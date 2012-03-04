<?php
//echo "query : " . $_SERVER["REQUEST_URI"];

if( preg_match(",(arton[0-9]+\.jpg)," ,  $_SERVER["REQUEST_URI"] , $matches) ) {
	$img_name = $matches[0];
	$img_orig = "../../IMG/" . $img_name;
}

// get original image's width and height
list($width, $height, $type) = getimagesize($img_orig);

// create an image object to work with
$img = imagecreatefromjpeg($img_orig);

// create a new dummy image with size 1x1
$img_r = imagecreatetruecolor(1, 1);

// downsample the original image into the dummy 1x1 image, thus mixing/averaging all its colours
imagecopyresampled($img_r, $img, 0, 0, 0, 0, 1, 1, $width, $height);

// free up some memory by killing the original image's GD object
imagedestroy($img);

// create file on disk for next time
imagejpeg($img_r , $img_name);

// send it directly while we're in a 404
imagejpeg($img_r);

// ad destroy it to free up some memory
imagedestroy($img_r);

?>