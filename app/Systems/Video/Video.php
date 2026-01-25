<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems\Video;

class Video
{

    public function saveToVideo($name=null){
        $this->saveToVideo = $name;
        return $this;
    }

    public function saveToImage($name=null){
        $this->saveToImage = $name;
        return $this;
    }

    public function file($file=null){
        $this->file = $file;
        return $this;
    }

    public function name($name=null){
        $this->name = $name;
        return $this;
    }

    public function init(){

        if($this->file){
            try{

                $ffmpeg = \FFMpeg\FFMpeg::create(array(
                    'ffmpeg.binaries'  => BASE_PATH . '/app/Systems/Video/ffmpeg', 
                    'ffprobe.binaries' => BASE_PATH . '/app/Systems/Video/ffprobe',
                    'timeout'          => 3600,
                    'ffmpeg.threads'   => 12,
                    'temporary_directory' => BASE_PATH . '/storage/temp/ffmpeg'
                ), $logger);

                return $ffmpeg->open($this->file);

            }catch (Exception $e){

                Logger::error("Video Error: {$e->getMessage()}");

            }
        }

    }

    public function saveImagePreview(){

        $instance = $this->init();

        $generatedName = $this->name ?: md5(time().'-'.uniqid());

        $instance->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(1))->save($this->saveToImage.'/'.$generatedName.'.webp');    

        return ["id"=>$generatedName, "name_image"=>$generatedName.'.webp'];

    }

    public function convertAndImagePreview(){

        $instance = $this->init();

        $generatedName = $this->name ?: md5(time().'-'.uniqid());

        $instance->filters()->resize(new \FFMpeg\Coordinate\Dimension(640, 360))->synchronize();

        $instance->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(1))->save($this->saveToImage.'/'.$generatedName.'.webp');

        $instance->save(new \FFMpeg\Format\Video\WebM(), $this->saveToVideo.'/'.$generatedName.'.webm');

        return ["id"=>$generatedName, "name_video"=>$generatedName.'.webm', "name_image"=>$generatedName.'.webp'];

    }

    public function parseLinkSource($link=null){
        global $app;

        if($link){

              if(strpos($link, "youtube.com") !== false || strpos($link, "youtu.be") !== false){

                if(strpos($link, "embed") === false){

                    if( strpos($link, "watch?") !== false ){
                        parse_str( explode("watch?", $link)[1] , $param);
                        if($param["v"]){
                           return (object)["link"=>"https://www.youtube.com/embed/".$param["v"], "image"=>$app->storage->name("label-logo-youtube.png")->path('images')->host(true)->get()];
                        }else{
                           return [];
                        }
                    }else{
                        $param = explode("/", trim($link, "/") );
                        if($param[3]){
                           return (object)["link"=>"https://www.youtube.com/embed/".$param[3], "image"=>$app->storage->name("label-logo-youtube.png")->path('images')->host(true)->get()];
                        }else{
                           return [];
                        }
                    }
              
                }else{
                    return (object)["link"=>$link, "image"=>$app->storage->name("label-logo-youtube.png")->path('images')->host(true)->get()];
                }

              }elseif(strpos($link, "rutube.ru") !== false){
                
                $variable = explode("?", $link);
                $link_ = end( explode("/", trim($variable[0], "/") ) );

                return (object)["link"=>"https://rutube.ru/play/embed/".$link_, "image"=>$app->storage->name("label-logo-rutube.png")->path('images')->host(true)->get()];

              }elseif(strpos($link, "vimeo.com") !== false){
                
                $link_ = end( explode("/", trim($link, "/") ) );

                return (object)["link"=>"https://player.vimeo.com/video/".$link_, "image"=>$app->storage->name("label-logo-vimeo.png")->path('images')->host(true)->get()];

              }elseif(strpos($link, "vkvideo.ru") !== false){

                if(strpos($link, "video_ext.php") === false){
                
                    $link_ = end( explode("/", trim($link, "/") ) );

                    if($link_){

                        $link_ = explode("?", $link_);

                        $link_ = explode("-", $link_[0]);

                        $link_ = explode("_", $link_[1]);

                        return (object)["link"=>"https://vkvideo.ru/video_ext.php?oid=-".$link_[0]."&id=".$link_[1], "image"=>$app->storage->name("label-logo-vk-video.png")->path('images')->host(true)->get()];

                    }

                }else{

                    return (object)["link"=>$link, "image"=>$app->storage->name("label-logo-vk-video.png")->path('images')->host(true)->get()];
                    
                }

              }

        }

        return [];
        
    }

}