public function uploadImages($images=null, $path=null, $count=1){
    global $app;

    $result = [];
    $images = explode(",", $images);

    if($images){
        foreach (array_slice($images, 0, $count) as $key => $value) {
            if($value){
                $filename = md5(time().uniqid()) . '.webp';
                $data = _file_get_contents($value);
                if($data){
                    if(_file_put_contents($path.'/'.$filename, $data)){
                        $size = filesize($path.'/'.$filename);
                        if($size > $app->settings->import_upload_min_size_image){
                            $result[] = clearPath($path.'/'.$filename);
                        }else{
                            unlink($path.'/'.$filename);
                        }
                    }
                }
            }
        }
    }

    return $result;

}