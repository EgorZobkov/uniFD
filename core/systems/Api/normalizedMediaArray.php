public function normalizedMediaArray($media=[]){

    $result = [];

    if($media){

        foreach ($media as $key => $value) {
            $info = pathinfo($value["link"]);
            if($value["type"] == "image" || $value["type"] == "video"){
                $result[][$value["type"]] = $info["filename"];
            }
        }

    }

    return $result;

}