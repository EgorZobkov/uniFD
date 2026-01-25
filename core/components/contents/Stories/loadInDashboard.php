public function loadInDashboard($id=0){
    global $app;

    $items = '';
    $media_container = '';

    $getStory = $app->model->stories_media->find("id=?", [$id]);

    if($getStory){

        $media = _json_decode($getStory->media);

        if($media["type"] == "image"){
            $media_container = '<img src="'.$app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->host(true)->get().'">';
        }else{
            $media_container = '<video class="story-video" name="media"><source src="'.$app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->host(true)->get().'" type="video/mp4"></video>';
        }

        if(!$getStory->status){
            $button_status = '<button class="btn btn-primary waves-effect waves-light changeStatusStory" data-id="'.$getStory->id.'">'.translate("tr_fd47eb2e78af443b8fac35a0ca0a5e0a").'</button>';
        }else{
            $button_status = '';
        }

        $items .= '

           <div class="user-stories-modal-container-item" data-id="'.$getStory->id.'" data-index="'.($key+1).'" >

              <div class="user-stories-modal-container-item-media" >
                 '.$media_container.'
              </div>

              <div class="user-stories-modal-container-item-footer" >
                 '.$button_status.'
              </div>

           </div>

        ';

    }

    return '
     <div class="user-stories-modal" >
        <div class="user-stories-modal-container" >

           <div class="user-stories-modal-container-close actionCloseModalStories" ><span><i class="ti ti-x"></i></span></div>
           
           '.$items.'

        </div>
     </div>
    ';

}