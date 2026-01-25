public function deleteMedia($media=null){
    global $app;

    if($media){

        foreach ($media["inline"] as $key => $value) {
            
            if($value["type"] == "image"){
                $app->storage->path('market-images')->name($value["folder"].'/'.$value["name"])->delete();
            }elseif($value["type"] == "video"){
                $app->storage->path('market-video')->name($value["folder"].'/'.$value["name"])->delete();
                $app->storage->path('market-images')->name($value["folder"].'/'.$value["preview"])->delete();
            }
            
        }
    }

}