<?php
header("Content-Type: text/css");
header("X-Content-Type-Options: nosniff");

define("SPRITE_NAME", "favicony.png");
echo ".do-webu u {background-image: url(" . SPRITE_NAME .")}	\n";

$top = 0;
$left = 0;
$maxWidth = 0;

$images = array();

// Create CSS
foreach (glob("*.png") as $filename) {
	if ($filename == SPRITE_NAME) continue;
	list($width, $height) = getimagesize($filename);
    echo "." . basename($filename, ".png") . " u {background-position: -{$left}px -{$top}px; width: {$width}px; height: {$height}px}" . "\n";

    $images[$filename] = array("top" => $top, "width" => $width, "height" => $height);
    
    $top += $height;
    $maxWidth = ($width > $maxWidth) ? $width : $maxWidth;
}

$maxHeight = $top;

// Create image sprite
$sprite = imagecreatetruecolor($maxWidth, $maxHeight);

// Make alpha channels work
imagealphablending($sprite, false);
$transparent = imagecolorallocatealpha($sprite, 255, 255, 255, 127);
imagefilledrectangle($sprite, 0, 0, $maxWidth, $maxHeight, $transparent);
imagealphablending($sprite, true);

foreach($images as $fn => $prop) {
    // Load image
    $img = imagecreatefrompng($fn);
    imagealphablending($img, true);

    // Copy over image
    imagecopy($sprite, $img, 0, $prop["top"], 0, 0, $prop["width"], $prop["height"]);

    // Free memory
    imagedestroy($img);
}

imagealphablending($sprite, false);
imagesavealpha($sprite, true);
imagepng($sprite, SPRITE_NAME);