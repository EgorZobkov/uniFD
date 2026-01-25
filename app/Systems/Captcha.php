<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

use App\Systems\Session;

class Captcha
{

    private static $bg = [
        "bg1.png",
    ];

    private static function generateCode(){
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        $code = substr(str_shuffle($chars), 0, 6);
        return $code;
    }

    private static function bgRand(){
        global $app;
        $rand = 0;
        if(isset(static::$bg[$rand])){
            if(file_exists($app->config->resource->path . "/captcha/" . static::$bg[$rand])){
                return $app->config->resource->path . "/captcha/" . static::$bg[$rand];
            }
        }
    }

    public static function image($sessionName=null){
        global $app;

        $code = static::generateCode();

        if(isset($sessionName)) Session::setSubarray($sessionName, $code);

        $image = imagecreatefrompng(static::bgRand());

        $size = 55;

        $color = imagecolorallocate($image, 0, 0, 0);

        $font = $app->config->resource->path . "/captcha/font.ttf";

        $angle = rand(-7, 7);

        $x = 40;
        $y = 90;

        imagefttext($image, $size, $angle, $x, $y, $color, $font, $code);

        ob_start();
        imagepng($image);
        $imageContent = ob_get_clean();

        imagedestroy($image);

        $data = 'data:image/png;base64,';
        $data .= base64_encode($imageContent);

        return $data;
        
    }

}