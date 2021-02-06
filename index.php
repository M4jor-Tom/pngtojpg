<?php
ini_set('memory_limit', '4G');
$errors = [];
foreach(glob('png/*.png') as $filePath)
{
    error_reporting(0);
    $image = imagecreatefrompng($filePath);
    error_reporting(1);

    if($image == false)
        $errors[] = $filePath;
    else
    {
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
        $aloneName = rtrim(ltrim($filePath, 'png/'), '.png');
        imagejpeg($bg, "jpg/$aloneName.jpg", $quality);
        imagedestroy($bg);
        unlink($filePath);
    }
}

var_dump('Couldn\'t convert those:', $errors);