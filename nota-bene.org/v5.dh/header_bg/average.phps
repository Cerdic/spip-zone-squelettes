<?php
/*

Calculate average colour of an image

parameters:		expects path to image file as "file" GET parameter
output:			simple JSON object with a single property "average" for the RGB values in HEX format

Patrick H. Lauke / www.splintered.co.uk / 19 September 2008

*/

// send correct MIME type for the response
header('Content-type: application/json');

// get original image's width and height
list($width, $height, $type) = getimagesize($_GET['file']);

// load the image into a new GD image object, depending on type (GIF, JPEG, PNG)
switch($type) {
	case IMAGETYPE_GIF:
		$img = imagecreatefromgif($_GET['file']);
		break;
	case IMAGETYPE_JPEG:
		$img = imagecreatefromjpeg($_GET['file']);
		break;
	case IMAGETYPE_PNG:
		$img = imagecreatefrompng($_GET['file']);
		break;
}

// create a new dummy image with size 1x1
$img_r = imagecreatetruecolor(1, 1);

// downsample the original image into the dummy 1x1 image, thus mixing/averaging all its colours
imagecopyresampled($img_r, $img, 0, 0, 0, 0, 1, 1, $width, $height);

// free up some memory by killing the original image's GD object
imagedestroy($img);

// grab the RGB values of the single pixel in the 1x1 dummy image
$rgb = imagecolorat($img_r, 0, 0);

// and kill the dummy image as well
imagedestroy($img_r);

// some bit-shifting to extract the individual R, G and B
$r = ($rgb >> 16) & 0xFF;
$g = ($rgb >> 8) & 0xFF;
$b = $rgb & 0xFF;

// output the final JSON, using sprintf to convert the RGB values into usable HEX values
echo '{ "average":"'.sprintf('#%02X%02X%02X', $r, $g, $b).'" }';
?>