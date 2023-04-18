<?php
/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project
****************/

session_start();
header("Content-type: image/png");
$random_str = md5(rand());
$captcha_text = substr($random_str, 0, 5);
$_SESSION['captcha_text'] = $captcha_text;
$image = imagecreate(120, 40);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 5, 35, 10, $captcha_text, $text_color);
for ($i = 0; $i < 100; $i++) {
    $pixel_color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
    imagesetpixel($image, rand(0, 120), rand(0, 40), $pixel_color);
}

imagepng($image);
imagedestroy($image);