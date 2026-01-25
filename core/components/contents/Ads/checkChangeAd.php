public function checkChangeAd($params=[], $ad=[]){

    if($ad->title != $params["title"]){
        return true;
    }

    $similar_text = similar_text($ad->text, $params["text"], $perc);

    if(intval($perc) != 100){
        return true;
    }

    if($ad->link_video != $params["link_video"]){
        return true;
    }

    if($params["media"]){

       $media = _json_decode($ad->media);

       foreach ($params["media"] as $key => $nested) {
           foreach ($nested as $type => $value) { 

              if(!$media["inline"][$value]){
                 return true;
              }

           }
       }

    }

    return false;

}