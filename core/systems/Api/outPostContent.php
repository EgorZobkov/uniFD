public function outPostContent($data=[]){
    global $app;

    $result = [];

    if($data->content){

        foreach (_json_decode(translateFieldReplace($data, "content", $_REQUEST["lang_iso"])) as $key => $nested) {
            foreach ($nested as $type => $value) { 
                
                if($type == "image"){

                    $result[] = ' <img src="'.$app->storage->name($value)->host(true)->get().'" >';

                }elseif($type == "link_video"){

                    $video = $app->video->parseLinkSource($value);

                    if($video){
                        $result[] = '
                             <iframe
                                src="'.$video->link.'"
                                allowfullscreen
                                allowtransparency
                              ></iframe>
                              ';
                    }else{
                        $result[] = '
                             <iframe
                                src="'.$value.'"
                                allowfullscreen
                                allowtransparency
                              ></iframe>
                              ';                            
                    }
                    
                }elseif($type == "text"){

                    $result[] = $value;
                    
                }elseif($type == "code"){
                    
                    $result[] = $value;

                }elseif($type == "separator"){
                    
                    $result[] = '<hr>';

                }

            }
        }

    }

    return implode("", $result);

}