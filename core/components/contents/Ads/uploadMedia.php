public function uploadMedia($media=[], $ad=[]){
    global $app;

    $result = [];
    $inline = [];
    $current_media = [];
    $current_inline = [];

    $folder = md5($app->datetime->format("Y-m-d")->getDate());

    if($media){

        if($ad){
            $current_media = _json_decode($ad->media);
            if($current_media){
                foreach ($current_media["inline"] as $value) {
                    if($value["name"]){
                        $current_inline[$value["name"]] = $value;
                    }else{
                        $current_inline[$value["link"]] = $value;
                    }
                }
            }
        }

        foreach ($media as $key => $nested) {
            foreach ($nested as $type => $value) {
                if(!$app->validation->isLink($value)->status){
                    $inline[] = ["type"=>$type, "name"=>$value];
                }else{
                    $inline[] = ["type"=>$type, "link"=>$value];
                }
            }
        }

        foreach (array_slice($inline, 0, $app->settings->board_publication_limit_count_media) as $key => $value) {

            if($value["type"] == "image"){

                if($value["name"]){

                    if(file_exists($app->config->storage->temp.'/'.$value["name"].'.webp')){
                        createFolder($app->config->storage->market->images.'/'.$folder);
                        if(copy($app->config->storage->temp.'/'.$value["name"].'.webp', $app->config->storage->market->images.'/'.$folder.'/'.$value["name"].'.webp')){
                           $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$folder]; 
                           $result["inline"][$value["name"]] = ["type"=>$value["type"], "name"=>$value["name"].'.webp', "folder"=>$folder]; 
                        }
                    }else{

                        if($current_inline){
                            if($current_inline[$value["name"].'.webp']){
                              $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$current_inline[$value["name"].'.webp']["folder"]]; 
                              $result["inline"][$value["name"]] = ["type"=>$value["type"], "name"=>$value["name"].'.webp', "folder"=>$current_inline[$value["name"].'.webp']["folder"]];
                              unset($current_inline[$value["name"].'.webp']);
                            }
                        }

                    }

                }else{

                    if($current_inline){
                        if($current_inline[$value["link"]]){
                          $result["images"][] = ["link"=>$value["link"]]; 
                          $result["inline"][$value["link"]] = ["type"=>$value["type"], "link"=>$value["link"]];   
                          unset($current_inline[$value["link"]]);
                        }
                    }

                }

            }elseif($value["type"] == "video"){

                if(file_exists($app->config->storage->temp.'/'.$value["name"].'.mp4')){
                    createFolder($app->config->storage->market->video.'/'.$folder);
                    if(copy($app->config->storage->temp.'/'.$value["name"].'.mp4', $app->config->storage->market->video.'/'.$folder.'/'.$value["name"].'.mp4')){
                       $result["video"][] = ["name"=>$value["name"].'.mp4', "folder"=>$folder, "preview"=>$value["name"].'.webp'];
                       $result["inline"][$value["name"]] = ["type"=>$value["type"], "name"=>$value["name"].'.mp4', "folder"=>$folder, "preview"=>$value["name"].'.webp'];
                    }
                }else{

                    if($current_inline){
                        if($current_inline[$value["name"].'.mp4']){
                           $result["video"][] = ["name"=>$value["name"].'.mp4', "folder"=>$current_inline[$value["name"].'.mp4']["folder"], "preview"=>$value["name"].'.webp'];
                           $result["inline"][$value["name"]] = ["type"=>$value["type"], "name"=>$value["name"].'.mp4', "folder"=>$current_inline[$value["name"].'.mp4']["folder"], "preview"=>$value["name"].'.webp'];
                           $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$current_inline[$value["name"].'.mp4']["folder"]];

                           unset($current_inline[$value["name"].'.webp']);
                           unset($current_inline[$value["name"].'.mp4']);
                        }
                    }

                }

                if(file_exists($app->config->storage->temp.'/'.$value["name"].'.webp')){
                    createFolder($app->config->storage->market->images.'/'.$folder);
                    if(copy($app->config->storage->temp.'/'.$value["name"].'.webp', $app->config->storage->market->images.'/'.$folder.'/'.$value["name"].'.webp')){
                       $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$folder];
                    }
                }

            }

            $app->storage->path('temp')->name($value["name"].'.webp')->delete();
            $app->storage->path('temp')->name($value["name"].'.mp4')->delete();

        }

    }

    if($current_inline){
        foreach ($current_inline as $key => $value) {
            if($value["type"] == "image"){
                $app->storage->path('market-images')->name($value["folder"].'/'.$value["name"])->delete();
            }elseif($value["type"] == "video"){
                $app->storage->path('market-video')->name($value["folder"].'/'.$value["name"])->delete();
                $app->storage->path('market-images')->name($value["folder"].'/'.$value["preview"])->delete();
            }
        }
    }

    return $result ? _json_encode($result) : null;

}