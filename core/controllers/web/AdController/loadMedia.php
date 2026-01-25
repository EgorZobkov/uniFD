public function loadMedia(){

    $result = '';

    $extensions_image = $this->settings->allowed_extensions_images;
    $extensions_video = $this->settings->allowed_extensions_videos;

    $data = normalizeFilesArray($_FILES["unidropzone_files"]);

    if($data){
        foreach ($data as $key => $value) {

            $generatedName = md5(time().'-'.uniqid());
            $extension = getInfoFile($value["name"])->extension;

            if(compareValues($extensions_image, $extension)){

                if($value["size"] < $this->settings->board_publication_max_size_image*1024*1024){

                    if(move_uploaded_file($value['tmp_name'], $this->config->storage->temp.'/'.$generatedName.'.'.$extension)){

                        $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->watermark(true)->resize();
                                
                        $result .= '
                          <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                          <img class="image-autofocus" src="'.$this->storage->name($upload["name"])->path('temp')->get().'" >
                          <input type="hidden" name="media[][image]" value="'.$generatedName.'" >
                        ';

                    }

                }

            }elseif(compareValues($extensions_video, $extension) && $this->settings->board_publication_add_video_status){
      
                if($value["size"] < $this->settings->board_publication_max_size_video*1024*1024){

                    if(move_uploaded_file($value['tmp_name'], $this->config->storage->temp.'/'.$generatedName.'.mp4')){

                        $upload = $this->video->file($this->config->storage->temp.'/'.$generatedName.'.mp4')->name($generatedName)->saveToImage($this->config->storage->temp)->saveImagePreview();

                        $result .= '
                          <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                          <img class="image-autofocus" src="'.$this->storage->name($upload["name_image"])->path('temp')->get().'" >
                          <input type="hidden" name="media[][video]" value="'.$generatedName.'" >
                        ';

                    }

                }

            }

        }
    }

    return json_answer(["content"=>$result]);

}