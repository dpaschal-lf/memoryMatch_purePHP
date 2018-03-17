<?php
define('IMAGECOUNT', 9);
define('CARDCOUNT', 18);
define('MM_SESSION_KEY', 'memoryMatch');
define('MISMATCH_REFRESH_TIME', 3);

function createImageArray($directory){
	$images = glob($directory);
	$finalImages = [];

	while(count($finalImages)< IMAGECOUNT){
		$randomIndex = rand(0, count($images) - 1);
		$finalImages[] = $images[$randomIndex];
		array_splice($images, $randomIndex, 1);
	}

	$totalImages = array_merge($finalImages, $finalImages);

	shuffle($totalImages);
	return $totalImages;	
}
?>