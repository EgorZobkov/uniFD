public function uploadAttach($attach_files=[]){
    global $app;

    $content = '';
    $result = [];

    $extensions_image = $app->settings->allowed_extensions_images;
    $extensions_video = $app->settings->allowed_extensions_videos;

    $data = normalizeFilesArray($attach_files);

    if($data){

        foreach ($data as $key => $value) {

            $generatedName = md5(time().'-'.uniqid());
            $extension = getInfoFile($value["name"])->extension;

            if(compareValues($extensions_image, $extension)){

                if($value["size"] < $app->settings->stories_max_size_image*1024*1024){

                    if(move_uploaded_file($value['tmp_name'], $app->config->storage->temp.'/'.$generatedName.'.'.$extension)){

                        $upload = $app->image->path($app->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($app->config->storage->temp)->resize();

                        $result = ["path"=>$app->storage->name($upload["name"])->path('temp')->host(true)->get(), "name"=>$generatedName, "type"=>"image"];
                                
                    }

                }

            }elseif(compareValues($extensions_video, $extension)){
      
                if($value["size"] < $app->settings->stories_max_size_video*1024*1024){

                    if(move_uploaded_file($value['tmp_name'], $app->config->storage->temp.'/'.$generatedName.'.mp4')){

                        $upload = $app->video->file($app->config->storage->temp.'/'.$generatedName.'.mp4')->name($generatedName)->saveToImage($app->config->storage->temp)->saveImagePreview();

                        $result = ["path"=>path($app->config->storage->temp.'/'.$generatedName.'.mp4', true), "name"=>$generatedName, "type"=>"video"];

                    }

                }

            }

        }

        if($result){

            if($result["type"] == "image"){

                $content = '
                 <div class="user-stories-modal" >
                    <div class="user-stories-modal-container" >

                       <div class="user-stories-modal-container-close actionCloseModalStories" ><span><i class="ti ti-x"></i></span></div>
                       
                       <div class="user-stories-modal-container-item" data-index="1" >

                          <div class="user-stories-modal-container-item-media" >
                             <img src="'.$result["path"].'">
                          </div>

                          <div class="user-stories-modal-container-item-footer" >
                             
                             <span class="btn-custom button-color-scheme1 width100 actionPublicationStory" data-name="'.$result["name"].'" data-type="'.$result["type"].'" >'.translate("tr_fd47eb2e78af443b8fac35a0ca0a5e0a").'</span>

                          </div>

                       </div>

                    </div>
                 </div>
                ';

                return ["status"=>true, "content"=>$content];

            }else{

                $content = '
                 <div class="user-stories-modal" >
                    <div class="user-stories-modal-container" >

                       <div class="user-stories-modal-container-close actionCloseModalStories" ><span><i class="ti ti-x"></i></span></div>
                       
                       <div class="user-stories-modal-container-item" data-index="1" >

                          <div class="user-stories-modal-container-item-media" >
                             <video class="story-video" ><source src="'.$result["path"].'" type="video/mp4"></video>
                          </div>

                          <div class="user-stories-modal-container-item-footer" >
                             
                             <span class="btn-custom button-color-scheme1 width100 actionPublicationStory" data-name="'.$result["name"].'" data-type="'.$result["type"].'" >'.translate("tr_fd47eb2e78af443b8fac35a0ca0a5e0a").'</span>

                          </div>

                       </div>

                    </div>
                 </div>
                ';

                return ["status"=>true, "content"=>$content];

            }

        }

    }

    return ["status"=>false];

}