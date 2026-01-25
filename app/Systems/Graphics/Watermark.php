<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems\Graphics;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Watermark{

    function init($path=null) {
        global $app;

        if(!$app->settings->watermark_status) return false;

        if($app->settings->watermark_type == "image"){
           $this->image($path);
        }elseif($app->settings->watermark_type == "title"){
           $this->title($path);
        }

    }

    function title($path=null){
       global $app;

       $r = 128; $g = 128; $b = 128;

       $title = $app->settings->watermark_title;
       $font = $app->config->storage->fonts . '/' . $app->settings->watermark_title_font;

       if(!isset($title) || !file_exists($font) || !file_exists($path)) return false;

       $sourceInfo = getimagesize($path);

       if($sourceInfo["mime"] == "image/jpeg") {
           $img = imagecreatefromjpeg($path);
       }elseif($sourceInfo["mime"] == "image/gif") {
           $img = imagecreatefromgif($path);
       }elseif($sourceInfo["mime"] == "image/png") {
           $img = imagecreatefrompng($path);
       }elseif($sourceInfo["mime"] == "image/webp") {
           $img = imagecreatefromwebp($path);
       }

       $width = imagesx($img);
       $height = imagesy($img);

       $angle =  -rad2deg(atan2((-$height),($width))); 
       
       if($app->settings->watermark_title_size == "big" ){
          $title = " ".$title." ";
       }elseif($app->settings->watermark_title_size == "medium" ){
          $title = "     ".$title."     ";
       }elseif($app->settings->watermark_title_size == "small" ){
          $title = "             ".$title."             ";
       }

       $c = imagecolorallocatealpha($img, $r, $g, $b, $app->settings->watermark_title_opacity);

       $size = (($width+$height)/2)*2/strlen($title);
       $box  = imagettfbbox ( $size, $angle, $font, $title );
       $x = $width/2 - abs($box[4] - $box[0])/2;
       $y = $height/2 + abs($box[5] - $box[1])/2;

       imagettftext($img,$size,$angle, $x, $y, $c, $font, $title);
       imagewebp($img, $path, 100);

     }

     function image($path=null) {
        global $app;

        if(!file_exists(BASE_PATH . $app->settings->watermark_image) || !file_exists($path)) return false;

        $watermarkInfo = getimagesize(BASE_PATH . $app->settings->watermark_image);
        $sourceInfo = getimagesize($path);

        $manager = new ImageManager(Driver::class);
        $image = $manager->read($path);
        $watermark = $manager->read(BASE_PATH . $app->settings->watermark_image);

        $wm_width = ($watermarkInfo[0] / 100) * $app->settings->watermark_image_percent_size ?: 30;
        $co = $wm_width / $sourceInfo[0];
        $wm_height = $sourceInfo[1] * $co;

        $watermark->scale($wm_width, $wm_height);

        if($app->settings->watermark_image_position == 1){
          $position = "top-left";       
        }elseif($app->settings->watermark_image_position == 2){
          $position = "top-right";       
        }elseif($app->settings->watermark_image_position == 3){
          $position = "bottom-left";      
        }elseif($app->settings->watermark_image_position == 4){
          $position = "bottom-right";        
        }elseif($app->settings->watermark_image_position == 5){
          $position = "center";         
        }else{
          $position = "bottom-right";         
        }

        $image->place(
             $watermark,
             $position, 
             15, 
             15,
             $app->settings->watermark_image_opacity ?: 100
        );

        $image->save($path);

     }


}



?>