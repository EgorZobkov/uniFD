public function uploadImagesAds($images=null, $count=1){
    global $app;

    $result = [];
    $inline = [];

    $folder = md5($app->datetime->format("Y-m-d")->getDate());

    $images = explode(",", $images);

    if($images){

        createFolder($app->config->storage->market->images.'/'.$folder);

        foreach (array_slice($images, 0, $count) as $key => $value) {
            if($value){
                $filename = md5(time().uniqid());
                $data = _file_get_contents($value);
                if($data){
                    if(_file_put_contents($app->config->storage->market->images.'/'.$folder.'/'.$filename.'.webp', $data)){
                        $size = filesize($app->config->storage->market->images.'/'.$folder.'/'.$filename.'.webp');
                        if($size > $app->settings->import_upload_min_size_image){
                            $inline[] = ["type"=>"image", "name"=>$filename];
                        }else{
                            unlink($app->config->storage->market->images.'/'.$folder.'/'.$filename.'.webp');
                        }
                    }
                }
            }
        }

        if($inline){

            foreach ($inline as $key => $value) {

               $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$folder]; 
               $result["inline"][$value["name"]] = ["type"=>"image", "name"=>$value["name"].'.webp', "folder"=>$folder]; 

            }

        }

    }

    return $result ? _json_encode($result) : [];

}