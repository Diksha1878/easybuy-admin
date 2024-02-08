<?php // Create image instances 
$dest = imagecreatefromJPEG('img/2.jpg'); 
$src = imagecreatefromJPEG('img/3.jpg'); 

// Copy and merge 
imagecopymerge($dest, $src, 0, 0, 0, 0, 300, 300, 100); 

// Output and free from memory 
header('Content-Type: image/gif'); 
imagegif($dest); 

imagedestroy($dest); 
imagedestroy($src); 