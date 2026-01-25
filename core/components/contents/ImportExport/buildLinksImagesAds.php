public function buildLinksImagesAds($images=null){
    global $app;

    $result = [];
    $inline = [];

    $images = explode(",", $images);

    if($images){

        foreach ($images as $key => $value) {
            if($value){
                $inline[] = ["type"=>"image", "link"=>$value];
            }
        }

        if($inline){

            foreach ($inline as $key => $value) {

               $result["images"][] = ["link"=>$value["link"]]; 
               $result["inline"][$value["link"]] = ["type"=>"image", "link"=>$value["link"]]; 

            }

        }

    }

    return $result ? _json_encode($result) : [];

}