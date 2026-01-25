public function getMedia($media=null){
    global $app;

    $gallery = [];
    $inline = [];
    $media = _json_decode($media);

    if(isset($media)){

        if($media["images"]){

            foreach ($media["images"] as $key => $value) { 

                if($value["link"]){
                    $gallery["images"][] = $value["link"];
                }elseif($value["name"]){
                    $gallery["images"][] = $app->storage->name($value["folder"].'/'.$value["name"])->path('market-images')->host(true)->get();
                }

            }               

        }

        if($media["video"]){

            foreach ($media["video"] as $key => $value) { 

                if($value["link"]){
                    $gallery["video"][] = $value["link"];
                }elseif($value["name"]){
                    $gallery["video"][] = $app->storage->name($value["folder"].'/'.$value["name"])->path('market-video')->host(true)->get();
                }

            }               

        }

        foreach ($media["inline"] as $key => $value) {
            if($value["type"] == "image"){
                 if($value["name"]){
                     $inline[] = ["link"=>$app->storage->name($value["folder"].'/'.$value["name"])->path('market-images')->host(true)->get(), "type"=>$value["type"], "name"=>$value["name"]];
                 }else{
                     $inline[] = ["link"=>$value["link"], "type"=>$value["type"], "name"=>null];
                 }
            }elseif($value["type"] == "video"){
                 if($value["name"]){
                    $inline[] = ["link"=>$app->storage->name($value["folder"].'/'.$value["name"])->path('market-video')->host(true)->get(), "preview"=>$app->storage->name($value["folder"].'/'.$value["preview"])->path('market-images')->host(true)->get(), "type"=>$value["type"], "name"=>$value["name"]];
                 }else{
                    $inline[] = ["link"=>$value["link"], "preview"=>$app->storage->noImage(), "type"=>$value["type"], "name"=>null];
                 }
            }
        }

    }

    return arrayToObject(["images"=>["first"=>$gallery["images"] ? $gallery["images"][0] : $app->storage->noImage(), "all"=>$gallery["images"] ?: []], "video"=>["all"=>$gallery["video"] ?: []], "inline"=>$inline ?: [], "count"=>count($inline)]);

}