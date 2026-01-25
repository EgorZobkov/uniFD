public function uploadMedia($name=null, $type=null){
    global $app;

    $result = [];

    $folder = md5(time().'-'.uniqid());

    if($name && $type){

        createFolder($app->config->storage->users->attached.'/'.$folder);

        if($type == "image"){

            $generatedName = md5(time().'-'.uniqid());

            if(file_exists($app->config->storage->temp.'/'.$name.'.webp')){

                if(copy($app->config->storage->temp.'/'.$name.'.webp', $app->config->storage->users->attached.'/'.$folder.'/'.$generatedName.'.webp')){
                   $result = ["name"=>$generatedName.'.webp', "folder"=>$folder, "type"=>$type];  
                }

            }

        }elseif($type == "video"){

            $generatedName = md5(time().'-'.uniqid());

            if(file_exists($app->config->storage->temp.'/'.$name.'.mp4')){

                if(copy($app->config->storage->temp.'/'.$name.'.mp4', $app->config->storage->users->attached.'/'.$folder.'/'.$generatedName.'.mp4')){
                   $result = ["name"=>$generatedName.'.mp4', "folder"=>$folder, "preview"=>$generatedName.'.webp', "type"=>$type];
                }

                if(file_exists($app->config->storage->temp.'/'.$name.'.webp')){
                   copy($app->config->storage->temp.'/'.$name.'.webp', $app->config->storage->users->attached.'/'.$folder.'/'.$generatedName.'.webp');
                }

            }

        }

        $app->storage->path('temp')->name($name.'.webp')->delete();
        $app->storage->path('temp')->name($name.'.mp4')->delete();

    }

    return $result ? _json_encode($result) : null;

}