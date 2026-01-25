<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Systems\Graphics\Watermark;
use App\Systems\Graphics\InitialAvatarGenerator\InitialAvatar;

class Image
{

    public function path($path=null){
        $this->path = $path;
        return $this;
    }

    public function name($name=null){
        $this->name = $name;
        return $this;
    }

    public function saveTo($path=null){
        $this->saveTo = $path;
        return $this;
    }

    public function saveExt($name=null){
        $this->saveExt = $name;
        return $this;
    }

    public function watermark($status=null){
        $this->watermark = $status;
        return $this;
    }

    public function deleteOriginal($status=null){
        $this->deleteOriginal = $status;
        return $this;
    }

    public function save($instances,$originalPath=null,$saveTo=null, $filename=null){

        $watermark = new Watermark();

        $saveExt = $this->saveExt;
        $watermarkStatus = $this->watermark;
        $deleteOriginal = $this->deleteOriginal;

        $this->saveExt(null);
        $this->watermark(null);
        $this->deleteOriginal(null);

        if(isset($saveExt)){
            $instances->save("{$saveTo}/{$filename}.{$saveExt}");
            if(isset($watermarkStatus)) $watermark->init("{$saveTo}/{$filename}.{$saveExt}");
            if(isset($deleteOriginal)) unlink($originalPath);
            return ["name"=>"{$filename}.{$saveExt}", "path"=>"{$saveTo}/{$filename}.{$saveExt}"];
        }else{
            $instances->save("{$saveTo}/{$filename}.webp", IMAGETYPE_WEBP);
            if(isset($watermarkStatus)) $watermark->init("{$saveTo}/{$filename}.webp");
            if(isset($deleteOriginal)) unlink($originalPath);
            return ["name"=>"{$filename}.webp", "path"=>"{$saveTo}/{$filename}.webp"];
        }
  
    }

    public function crop($width=200, $height=200){

        if(isset($this->path) && isset($this->name) && isset($this->saveTo)){

            $originalPath = $this->path.'/'.$this->name;

            if(file_exists($originalPath)){

                $manager = new ImageManager(Driver::class);

                $image = $manager->read($originalPath)->crop($width, $height);

                return $this->save($image,$originalPath,$this->saveTo,getInfoFile($this->name)->filename);
            }

        }

        return [];

    }

    public function scale(){

        if(isset($this->path) && isset($this->name) && isset($this->saveTo)){

            $originalPath = $this->path.'/'.$this->name;

            if(file_exists($originalPath)){

                $manager = new ImageManager(Driver::class);

                $image = $manager->read($originalPath)->scale(500);

                return $this->save($image,$originalPath,$this->saveTo,getInfoFile($this->name)->filename);

            }
        }

        return [];

    }

    public function resize($width=1024, $height=768){

        if(isset($this->path) && isset($this->name) && isset($this->saveTo)){

            $originalPath = $this->path.'/'.$this->name;

            if(file_exists($originalPath)){

                $manager = new ImageManager(Driver::class);

                $image = $manager->read($originalPath)->scale($width, $height);

                return $this->save($image,$originalPath,$this->saveTo,getInfoFile($this->name)->filename);

            }
        }

    }

    public function toBase64ByData($data=null, $decrypt=false){
        
        if($data){
            if($decrypt){
                return 'data:image/webp;base64,' . base64_encode(decrypt($data));
            }else{
                return 'data:image/webp;base64,' . base64_encode($data);
            }
        }        
        
    }

    public function toBase64ByPath($path=null, $decrypt=false){
        
        if(file_exists($path)){

            if($decrypt){
                return 'data:image/webp;base64,' . base64_encode(decrypt(_file_get_contents($path)));
            }else{
                return 'data:image/webp;base64,' . base64_encode(_file_get_contents($path));
            }   

        }
        
    }

    public function generateAvatar($string=null){
        global $app;

        try {

            if($string){
                $avatarPath = $app->config->storage->users->avatars.'/'.md5(time().uniqid()).".webp";
                $avatar = new InitialAvatar();
                $image = $avatar->background( randomColorCertain() )->color('#000000')->size(128)->name($string)->generate();
                $image->save($avatarPath);

                return clearPath($avatarPath);
            }

        } catch (Exception $e) {
            logger("Generate avatar: {$e->getMessage()}");
        }

        return null;
    }

}