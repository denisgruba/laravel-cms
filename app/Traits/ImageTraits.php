<?php namespace App\Traits;

trait ImageTraits
{
    public function resizeAndSaveImage($file, $saveTo, $maxDimension=1024){

        $info = getimagesize($file);

        $width = $info['0'];
        $height = $info['1'];
        $mime = $info['mime'];

        $size = filesize($file)/1024;

        if($width>$maxDimension OR $height>$maxDimension OR $size>(150)) {

            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($file);
            } elseif ($info['mime'] == 'image/gif') {
                $image = imagecreatefromgif($file);
            } elseif ($info['mime'] == 'image/png') {
                $image = imagecreatefrompng($file);
            }

            if($width>$maxDimension OR $height>$maxDimension) {
                if($width>$height) {
                    $height = intval(($height/$width) * $maxDimension);
                    $width = $maxDimension;
                } else {
                    $width = intval(($width/$height) * $maxDimension);
                    $height = $maxDimension;
                }
                $image = imagescale($image, $width, $height, $mode = IMG_BILINEAR_FIXED);
            }
            imagejpeg($image, $saveTo);
        } else {
            move_uploaded_file ($file, $saveTo);
        }
        return true;
    }
}
