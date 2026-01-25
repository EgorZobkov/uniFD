<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Storage
{

    public function pathList(){
        global $app;
        return [
            "images" => $app->config->storage->images,
            "temp" => $app->config->storage->temp,
            "user-avatar" => $app->config->storage->users->avatars,
            "user-attached" => $app->config->storage->users->attached,
            "favicon" => $app->config->storage->favicon,
            "files" => $app->config->storage->files,
            "files-import-export" => $app->config->storage->files_import_export,
            "market-images" => $app->config->storage->market->images,
            "market-video" => $app->config->storage->market->video,
            "manager" => $app->config->storage->manager,
            "blog" => $app->config->storage->blog,
        ];
    }

    public function host($status=null){
        $this->host = $status;
        return $this;
    }

    public function name($name=null){
        $this->name = $name;
        return $this;
    }

    public function files($files=null){
        $this->files = $files;
        return $this;
    }

    public function extList($name=null){
        $this->extList = $name;
        return $this;
    }

    public function saveExt($name=null){
        $this->saveExt = $name;
        return $this;
    }

    public function saveTo($path=null){
        $this->saveTo = $path;
        return $this;
    }

    public function path($name=null){
        $this->path = $name;
        return $this;
    }

    public function use($name=null){
        $this->use = $name;
        return $this;
    }

    public function width($width=null){
        $this->width = $width;
        return $this;
    }

    public function height($height=null){
        $this->height = $height;
        return $this;
    }

    public function deleteOriginal($status=null){
        $this->deleteOriginal = $status;
        return $this;
    }

    public function decrypt($status=null){
        $this->decrypt = $status;
        return $this;
    }

    public function encrypt($status=null){
        $this->encrypt = $status;
        return $this;
    }

    public function type($name=null){
        $this->type = $name;
        return $this;
    }

    public function watermark($status=null){
        $this->watermark = $status;
        return $this;
    }

    public function logo(){
        global $app;
        return $this->name($app->settings->logo_main)->get();
    }

    public function logoMini(){
        global $app;
        return $this->name($app->settings->logo_emblem)->get();
    }

    public function noImage(){
        global $app; 
        return path($app->config->storage->no_image,true);
    }

    public function get(){
        global $app;

        $name = $this->name;
        $path = $this->path;
        $host = $this->host;

        $this->name(null);
        $this->path(null);
        $this->host(null);

        if($name){

            if(strpos($name, "://") !== false){
                return $name;
            }

            if($path){

                foreach ($this->pathList() as $key => $value) {
                    if($key == $path){
                        if(file_exists($value."/".$name)){
                            return path($value."/".$name,$host);
                        }else{
                            return $this->host($host)->noImage();
                        } 
                        break;                    
                    }
                }

            }else{

               if(file_exists(BASE_PATH.$name)){
                   if($host){
                       return getHost().$name;
                   }else{
                       return path(BASE_PATH.$name);
                    }
               }else{
                   return $this->host($host)->noImage();
               }  

           }

        }

        return $this->host($host)->noImage();
    }

    public function getLocal($filename=null){
        global $app;

        if($filename){

            if(strpos($filename, "://") !== false){
                return $filename;
            }

            if(file_exists(BASE_PATH.$filename)){
               return getHost().$filename;
            }else{
               return $this->noImage();
            }

        }

        return $this->noImage();
    }

    public function base64(){
        global $app;

        $name = $this->name;
        $decrypt = $this->decrypt;

        $this->name(null);
        $this->decrypt(null);

        if($name){

            return $app->image->toBase64ByPath(BASE_PATH."/".$name,$decrypt);

        }
        return $this->noImage();
    }

    public function getAssetImage($name=null){
        global $app;
        if(isset($app->view->path) && $name){

            if(strpos($name, "://") !== false){
                return $name;
            }

            if(file_exists($app->view->path."/assets/images/".$name)){
                return path($app->view->path."/assets/images/".$name, $this->host);
            }else{
                return $this->noImage();
            } 
        }
        return $this->noImage();
    }

    public function exist(){
        global $app;

        $name = $this->name;
        $path = $this->path;

        $this->name(null);
        $this->path(null);

        if($name){

            if(isset($path)){
                foreach ($this->pathList() as $key => $value) {
                    if($key == $path){
                        if(file_exists($value."/".$name)){
                            return true;
                        }                     
                    }
                }
            }else{

                if(file_exists(BASE_PATH."/".$name)){
                    return true;
                }

            }

        }
        return false;
    }

    public function upload(){
        global $app;

        $resultUpload = [];
        $pathUpload = "";
        $saveExt = $this->saveExt;
        $extList = $this->extList;
        $watermark = $this->watermark;
        $use = $this->use;
        $type = $this->type;
        $deleteOriginal = $this->deleteOriginal;
        $encrypt = $this->encrypt;
        $path = $this->path;
        $width = $this->width;
        $height = $this->height;

        $this->saveExt(null);
        $this->use(null);
        $this->extList(null);
        $this->watermark(null);
        $this->type(null);
        $this->deleteOriginal(null);
        $this->encrypt(null);
        $this->path(null);
        $this->width(null);
        $this->height(null);

        if(isset($this->files) && isset($path)){

            if(isset($extList)){
                if(is_array($extList)){
                    $allowed_extensions = $extList;
                }else{
                    if($extList == "images"){
                        $allowed_extensions = $app->settings->allowed_extensions_images;
                    }elseif($extList == "files"){
                        $allowed_extensions = $app->settings->allowed_extensions_files;
                    }else{
                        $allowed_extensions = $app->settings->allowed_extensions_images;
                    }
                }
            }else{
                if(isset($type)){
                    if($type == "image"){
                        $allowed_extensions = $app->settings->allowed_extensions_images;
                    }elseif($type == "file"){
                        $allowed_extensions = $app->settings->allowed_extensions_files;
                    }
                }else{
                    $allowed_extensions = $app->settings->allowed_extensions_images;
                }                
            }

            foreach ($this->pathList() as $key => $value) {
                if($key == $path){
                    $pathUpload = $value; 
                    break;                   
                }
            }

            $data = normalizeFilesArray($this->files);

            if($data){
                foreach ($data as $key => $value) {

                    $generatedName = md5(time().'-'.uniqid());
                    $extension = getInfoFile($value["name"])->extension;

                    if($extension){

                        if (!in_array($extension, $allowed_extensions)){
                            return [];
                        }

                        if(isset($type)){
                            if($type == "image"){
                                
                                if(move_uploaded_file($value['tmp_name'], $app->config->storage->temp.'/'.$generatedName.'.'.$extension)){

                                    if(isset($use)){
                                        if($use == "crop"){
                                            $resultUpload = $app->image->path($app->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($pathUpload)->saveExt($saveExt)->watermark($watermark)->deleteOriginal($deleteOriginal)->crop();
                                        }elseif($use == "resize"){
                                            $resultUpload = $app->image->path($app->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($pathUpload)->saveExt($saveExt)->watermark($watermark)->deleteOriginal($deleteOriginal)->resize($width, $height);
                                        }
                                    }else{
                                        $resultUpload = $app->image->path($app->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($pathUpload)->saveExt($saveExt)->watermark($watermark)->deleteOriginal($deleteOriginal)->resize($width, $height);
                                    }
                                }

                            }elseif($type == "file"){
                               
                                if(move_uploaded_file($value['tmp_name'], $pathUpload.'/'.$generatedName.'.'.$extension)){
                                    $resultUpload = ["name"=>$generatedName.'.'.$extension];
                                }

                            }
                        }else{

                            if(move_uploaded_file($value['tmp_name'], $app->config->storage->temp.'/'.$generatedName.'.'.$extension)){
                                if(isset($use)){
                                    if($use == "crop"){
                                        $resultUpload = $app->image->path($app->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($pathUpload)->saveExt($saveExt)->watermark($watermark)->deleteOriginal($deleteOriginal)->crop();
                                    }elseif($use == "resize"){
                                        $resultUpload = $app->image->path($app->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($pathUpload)->saveExt($saveExt)->watermark($watermark)->deleteOriginal($deleteOriginal)->resize($width, $height);
                                    }
                                }else{
                                    $resultUpload = $app->image->path($app->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($pathUpload)->saveExt($saveExt)->watermark($watermark)->deleteOriginal($deleteOriginal)->resize($width, $height);
                                }
                            }

                        }

                    }

                    if($encrypt){
                        $this->encryptFile($resultUpload["path"]);
                    }

                    return $resultUpload;

                }
            }

        }

        return [];
    }

    public function uploadAttachFiles($files=[], $saveTo=null){
        global $app;

        $result = [];

        $path = $saveTo.'/'.md5(time().'-'.uniqid());

        if($files){
            if(is_array($files)){

                createFolder($path);

                foreach (array_slice($files, 0,10) as $key => $value) {

                    $extension = getInfoFile($value)->extension;
                    $generatedName = md5(time().'-'.uniqid()) . '.' . $extension;

                    if(copy($app->config->storage->temp.'/'.$value, $path.'/'.$generatedName)){
                        $result[] = clearPath($path.'/'.$generatedName);
                    }

                }
            }
        }

        return $result;

    }

    public function clearAttachFiles($files=[]){
        global $app;

        $result = [];

        if($files){
            if(is_array($files)){
                foreach ($files as $key => $value) {

                    if(file_exists(BASE_PATH.$value)){
                        unlink(BASE_PATH.$value);
                    }

                }
            }
        }

        return $result;

    }

    public function delete(){
        global $app;

        $name = $this->name;
        $path = $this->path;

        $this->name(null);
        $this->path(null);

        if(isset($name)){

            if(isset($path)){

                foreach ($this->pathList() as $key => $value) {
                    if($key == $path){
                        if(file_exists($value.'/'.$name)){
                            unlink($value.'/'.$name);
                        }  
                        break;                 
                    }
                }

            }else{

                if(file_exists(BASE_PATH.$name)){
                    unlink(BASE_PATH.$name);
                } 

            }

        }

    }

    public function encryptFile($path=null){

        $original = '';
        $encrypt = '';

        if(file_exists($path)){
            $original = _file_get_contents($path);
            $encrypt = encrypt($original);
            _file_put_contents($path, $encrypt);
        }

        return (object)["original"=>$original, "encrypt"=>$encrypt];
        
    }

    public function copy(){
        global $app;

        if(file_exists($this->path.'/'.$this->name)){

            if(copy($this->path.'/'.$this->name, $this->saveTo.'/'.$this->name)) {
                return (object)["path"=>clearPath($this->saveTo.'/'.$this->name)];
            }else {
                return null;
            }

        }

    }

}