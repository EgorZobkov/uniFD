public function load($stories_user_id=0, $user_id=0, $category_id=0){
    global $app;

    $timeline = '';
    $items = '';
    $media_container = '';
    $subscribe_container = '';

    if(intval($category_id)){
        $getStoriesMedia = $app->model->stories_media->sort("time_create desc")->getAll("user_id=? and status=? and category_id IN(".$app->component->ads_categories->joinId($category_id)->getParentIds($category_id).")", [$stories_user_id, 1]);
    }else{
        $getStoriesMedia = $app->model->stories_media->sort("time_create desc")->getAll("user_id=? and status=?", [$stories_user_id, 1]);
    }

    if($getStoriesMedia){

        foreach ($getStoriesMedia as $key => $value) {

            $ad_button = '';
            $delete_button = '';

            if($key == 0){
                $this->fixViewStories($value["id"], $user_id);
            }

            $timeline .= '<div data-index="'.($key+1).'" > <span></span> </div>';

            $media = _json_decode($value["media"]);

            if($media["type"] == "image"){
                $media_container = '<img src="'.$app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->host(true)->get().'">';
                $duration = $app->settings->stories_max_duration_image;
            }else{
                $media_container = '<video class="story-video" name="media"><source src="'.$app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->host(true)->get().'" type="video/mp4"></video>';
                $duration = $app->settings->stories_max_duration_video;
            }

            if($value["user_id"] != $app->user->data->id){
                if($app->component->profile->isSubscription($user_id, $value["user_id"])){
                    $subscribe_container = '<div class="mt5" ><span class="btn-custom-mini button-color-scheme3 actionSubscribeUser" data-id="'.$value["user_id"].'" >'.translate("tr_d2023e4c921d1cc5865f230480442d3c").'</span></div>';
                }else{
                    $subscribe_container = '<div class="mt5" ><span class="btn-custom-mini button-color-scheme3 actionSubscribeUser" data-id="'.$value["user_id"].'" >'.translate("tr_3b1913989f1a538261b8abf5ffc88d4b").'</span></div>';
                }
            }

            if($user_id == $value["user_id"]){
                $delete_button = '<span class="btn-custom button-color-scheme6 width100 actionDeleteStory" data-id="'.$value["id"].'" >'.translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8").'</span>';
            }

            if($user_id != $value["user_id"]){
                if($value["item_id"]){
                    $ad = $app->component->ads->getAd($value["item_id"]);
                    if($ad){
                        $ad_button = '<a class="btn-custom button-color-scheme1 width100" href="'.$app->component->ads->buildAliasesAdCard($ad).'" >'.translate("tr_4d6400738b124c2747d12988e45a84e8").'</a>';
                    }
                }
            }

            $user = $app->component->profile->getUserCard($value["user_id"]);

            $items .= '

               <div class="user-stories-modal-container-item" data-id="'.$value["id"].'" data-index="'.($key+1).'" data-duration="'.$duration.'" >

                  <div class="user-stories-modal-container-item-header" >

                     <div class="user-stories-modal-container-item-header-user" >
                        <div class="user-stories-modal-container-item-header-user-box1" >
                           <div class="user-stories-modal-container-item-header-user-avatar" >
                              <img src="'.$user->avatar_src.'" class="image-autofocus" >
                           </div>
                        </div>
                        <div class="user-stories-modal-container-item-header-user-box2" >
                           <div>
                           <a href="'.$user->link.'" >'.trimStr($user->name, 70, true).'</a>
                           '.$subscribe_container.'
                           </div>
                        </div>
                     </div>

                  </div>

                  <div class="user-stories-modal-container-item-media" >
                     '.$media_container.'
                  </div>

                  <div class="user-stories-modal-container-item-footer" >
                     '.$ad_button.'
                     '.$delete_button.'
                  </div>

               </div>

            ';

        }

    }

    return '
     <div class="user-stories-modal" >
        <div class="user-stories-modal-container" >

           <div class="user-stories-modal-container-close actionCloseModalStories" ><span><i class="ti ti-x"></i></span></div>
           
           <div class="user-stories-modal-container-header-timeline" >
              '.$timeline.'
           </div>

           '.$items.'

           <div class="user-stories-modal-container-prev-load actionPrevLoadStory" ></div>
           <div class="user-stories-modal-container-next-load actionNextLoadStory" ></div>

        </div>
     </div>
    ';

}