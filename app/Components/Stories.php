<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;
use App\Systems\Container;
use App\Systems\Graphics\Collage\MakeCollage;

class Stories
{

 public $alias = "stories";

 public function addWaitingMakeCollage($item_id=0, $count_day=0, $user_id=0){
    global $app;
    $app->model->stories_waiting_make_collage->insert(["item_id"=>(int)$item_id, "count_day"=>(int)$count_day, "user_id"=>(int)$user_id]);
}

public function changeStatus($story_id=0){
    global $app;

    $getStory = $app->model->stories_media->find("id=?", [$story_id]);

    $tariff = $app->component->service_tariffs->getOrderByUserId($getStory->user_id);

    if($tariff->items->stories_3_days){
        $time_expiration = $app->datetime->addDay(3)->getDate();
    }elseif($tariff->items->stories_7_days){
        $time_expiration = $app->datetime->addDay(7)->getDate();
    }else{
        $time_expiration = $app->datetime->addHours($app->settings->stories_period_placement)->getDate();
    }

    $app->model->stories_media->update(["status"=>1, "time_expiration"=>$time_expiration],$story_id);

}

public function checkViewStories($story_id=0, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");

    if($user_id){
        $check = $app->model->stories_media_views->find("story_id=? and user_id=?", [$story_id,$user_id]);
    }else{
        $check = $app->model->stories_media_views->find("story_id=? and session_id=?", [$story_id,$session_id]);
    }

    if($check){
        return true;
    }

    return false;

}

public function delete($story_id=0, $user_id=0){
    global $app;

    if($user_id){
        $getStory = $app->model->stories_media->find("id=? and user_id=?", [$story_id,$user_id]);
    }else{
        $getStory = $app->model->stories_media->find("id=?", [$story_id]);
    }

    if($getStory){

        $app->model->stories_media->delete("id=?", [$story_id]);

        $media = _json_decode($getStory->media);
        $app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->delete();
        $app->storage->path("user-attached")->name($media["folder"].'/'.$media["preview"])->delete();

        if(!$app->model->stories_media->count("user_id=?", [$user_id])){
            $app->model->stories->delete("user_id=?", [$user_id]);
        }

        $app->model->stories_media_views->delete("story_id=?", [$story_id]);
        
    }

}

public function deleteAllByUserId($user_id=0){
    global $app;

    $getStories = $app->model->stories_media->getAll("user_id=?", [$user_id]);

    if($getStories){

        foreach ($getStories as $key => $value) {
            
            $media = _json_decode($value["media"]);
            $app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->delete();
            $app->storage->path("user-attached")->name($media["folder"].'/'.$media["preview"])->delete();

        }
        
    }

    $app->model->stories->delete("user_id=?", [$user_id]);
    $app->model->stories_media->delete("user_id=?", [$user_id]);
    $app->model->stories_media_views->delete("user_id=?", [$user_id]);

}

public function fixViewStories($story_id=0, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");

    if($user_id){
        $check = $app->model->stories_media_views->find("story_id=? and user_id=?", [$story_id,$user_id]);
    }else{
        $check = $app->model->stories_media_views->find("story_id=? and session_id=?", [$story_id,$session_id]);
    }

    if(!$check){
        $app->model->stories_media_views->insert(["story_id"=>$story_id, "user_id"=>$user_id?:0, "session_id"=>$session_id?:null]);
    }

}

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

public function makeCollageItemAndPublication($item_id=0, $count_day=0){
    global $app;

    $images = [];
    $media = [];

    $ad = $app->component->ads->getAd($item_id);

    if(!$ad || $ad->delete){
        return;
    }

    if($ad->media->images->all){

        foreach (array_slice($ad->media->inline, 0, 4) as $key => $value) {

            if($value->type == "image"){
                if(@getimagesize($value->link)){
                    $images[] = $value->link;
                }
            }elseif($value->type == "video"){
                $images[] = $value->preview;
            }

        }

        if($images){
            $folder = md5(time().'-'.uniqid());
            $generatedName = md5(time().'-'.uniqid());
            createFolder($app->config->storage->users->attached.'/'.$folder);
            $collage = new MakeCollage();
            $result = $collage->make(600, 600)->padding(5)->background('#000')->from($images);
            $result->save($app->config->storage->users->attached.'/'.$folder."/".$generatedName.".webp");
            $media = ["name"=>$generatedName.'.webp', "folder"=>$folder, "type"=>"image"];
        }else{
            return;
        }

    }else{
        return;
    }

    if($count_day){
        $time_expiration = $app->datetime->addDay($count_day)->getDate();
    }else{
        $time_expiration = $app->datetime->addHours($app->settings->stories_period_placement)->getDate();
    }

    $getStory = $app->model->stories->find("user_id=?", [$ad->user_id]);

    if($getStory){

       $app->model->stories_media->insert(["user_id"=>$ad->user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media ? _json_encode($media) : null, "status"=>1, "time_expiration"=>$time_expiration, "city_id"=>$ad->city_id, "category_id"=>$ad->category_id, "item_id"=>$item_id]);

       $app->model->stories->update(["time_create"=>$app->datetime->getDate()], ["user_id=?", [$ad->user_id]]);

    }else{

       $app->model->stories->insert(["user_id"=>$ad->user_id, "time_create"=>$app->datetime->getDate()]);

       $app->model->stories_media->insert(["user_id"=>$ad->user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media ? _json_encode($media) : null, "status"=>1, "time_expiration"=>$time_expiration, "city_id"=>$ad->city_id, "category_id"=>$ad->category_id, "item_id"=>$item_id]);

    }

}

public function outUsersStories(){
    global $app;

    $getUserStories = $app->model->stories->sort("time_create desc limit 30")->getAll();

    if($getUserStories){

        foreach ($getUserStories as $key => $value) {

            $user = $app->component->profile->getUserCard($value["user_id"]);

            $getStory = $app->model->stories_media->sort("time_create desc")->find("user_id=? and status=?", [$value["user_id"],1]);

            if($getStory){

                $media = _json_decode($getStory->media);

                ?>
                <div class="widget-stories-item actionOpenModalUserStories swiper-slide" data-id="<?php echo $value["user_id"]; ?>" >
                    <div>
                        <div class="widget-stories-item-circle <?php if(!$this->checkViewStories($getStory->id, $app->user->data->id)){ ?>stories-border-no-view<?php } ?>" >
                            <div class="widget-stories-item-circle-image" >
                                <?php if($media["type"] == "image"){ ?>
                                    <img src="<?php echo $app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->host(true)->get(); ?>" class="image-autofocus" >
                                <?php }else{ ?>
                                    <img src="<?php echo $app->storage->path("user-attached")->name($media["folder"].'/'.$media["preview"])->host(true)->get(); ?>" class="image-autofocus" >
                                <?php } ?>
                            </div>
                        </div>
                        <span class="widget-stories-item-title" title="<?php echo $user->name; ?>" ><?php echo trimStr($user->name, 25, true); ?></span>
                    </div>
                </div>                
                <?php

            }

        }

    }

}

public function outUsersStoriesInCatalog($category_id=0, $city_id=0){
    global $app;

    if(!$category_id){
        return '';
    }

    $stories = [];

    $getUserStories = $app->model->stories_media->sort("time_create desc limit 50")->getAll("category_id IN(".$app->component->ads_categories->joinId($category_id)->getParentIds($category_id).") and status=?", [1]);

    if($getUserStories){
        foreach ($getUserStories as $key => $value) {
            $stories[$value["user_id"]] = $value;
        }
    }

    if($stories){

        foreach ($stories as $key => $value) {

            $user = $app->component->profile->getUserCard($value["user_id"]);

            $media = _json_decode($value["media"]);

            ?>
            <div class="widget-stories-item actionOpenModalUserStories swiper-slide" data-id="<?php echo $value["user_id"]; ?>" data-category-id="<?php echo $category_id; ?>" >
                <div>
                    <div class="widget-stories-item-circle <?php if(!$this->checkViewStories($value["id"], $app->user->data->id)){ ?>stories-border-no-view<?php } ?>" >
                        <div class="widget-stories-item-circle-image" >
                            <?php if($media["type"] == "image"){ ?>
                                <img src="<?php echo $app->storage->path("user-attached")->name($media["folder"].'/'.$media["name"])->host(true)->get(); ?>" class="image-autofocus" >
                            <?php }else{ ?>
                                <img src="<?php echo $app->storage->path("user-attached")->name($media["folder"].'/'.$media["preview"])->host(true)->get(); ?>" class="image-autofocus" >
                            <?php } ?>
                        </div>
                    </div>
                    <span class="widget-stories-item-title" title="<?php echo $user->name; ?>" ><?php echo trimStr($user->name, 25, true); ?></span>
                </div>
            </div>                
            <?php

        }

    }

}

public function publication($params=[], $user_id=0){
    global $app;

    $tariff = $app->component->service_tariffs->getOrderByUserId($user_id);

    if(!$tariff->items->add_stories){
        return json_answer(["status"=>false]);
    }

    $media = $this->uploadMedia($params['name'], $params['type']);

    if(!$media){
        return ["status"=>false, "answer"=>translate("tr_5806b0fd6cb91d6b69435dbac3b096c7")];
    }

    if($app->settings->stories_moderation_status){
        $status = 0;
    }else{
        $status = 1;
    }

    if($params['type'] == "image"){
        $duration = $app->settings->stories_max_duration_image ?: 30;
    }else{
        $duration = $app->settings->stories_max_duration_video ?: 30;
    }

    if($tariff->items->stories_3_days){
        $time_expiration = $app->datetime->addDay(3)->getDate();
    }elseif($tariff->items->stories_7_days){
        $time_expiration = $app->datetime->addDay(7)->getDate();
    }else{
        $time_expiration = $app->datetime->addHours($app->settings->stories_period_placement)->getDate();
    }

    $getStory = $app->model->stories->find("user_id=?", [$user_id]);

    if($getStory){

       $app->model->stories_media->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media, "status"=>$status, "time_expiration"=>$time_expiration, "duration"=>$duration]);

       $app->model->stories->update(["time_create"=>$app->datetime->getDate()], ["user_id=?", [$user_id]]);

    }else{

       $app->model->stories->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate()]);

       $app->model->stories_media->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate(), "media"=>$media, "status"=>$status, "time_expiration"=>$time_expiration, "duration"=>$duration]);

    }

    $app->event->addStories(["user_id"=>$user_id]);

    if($app->settings->stories_moderation_status){
        return ["status"=>true, "answer"=>translate("tr_bd3b3e8aec6a731f69092d1dc03fd0ea")];
    }else{
        return ["status"=>true, "answer"=>translate("tr_86c67ada3b0abc338f70d5e887c81c0d")];
    }

}

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

public function uploadMedia($name=null, $type=null){
    global $app;

    $result = [];

    $folder = md5(time().'-'.uniqid());

    if($name && $type){

        createFolder($app->config->storage->users->attached.'/'.$folder);

        if($type == "image"){

            $generatedName = md5(time().'-'.uniqid());

            if(file_exists($app->config->storage->temp.'/'.$name.'.webp')){

                if(copy($app->config->storage->temp.'/'.$name.'.webp', $app->config->storage->users->attached.'/'.$folder.'/'.$generatedName.'.webp')){
                   $result = ["name"=>$generatedName.'.webp', "folder"=>$folder, "type"=>$type];  
                }

            }

        }elseif($type == "video"){

            $generatedName = md5(time().'-'.uniqid());

            if(file_exists($app->config->storage->temp.'/'.$name.'.mp4')){

                if(copy($app->config->storage->temp.'/'.$name.'.mp4', $app->config->storage->users->attached.'/'.$folder.'/'.$generatedName.'.mp4')){
                   $result = ["name"=>$generatedName.'.mp4', "folder"=>$folder, "preview"=>$generatedName.'.webp', "type"=>$type];
                }

                if(file_exists($app->config->storage->temp.'/'.$name.'.webp')){
                   copy($app->config->storage->temp.'/'.$name.'.webp', $app->config->storage->users->attached.'/'.$folder.'/'.$generatedName.'.webp');
                }

            }

        }

        $app->storage->path('temp')->name($name.'.webp')->delete();
        $app->storage->path('temp')->name($name.'.mp4')->delete();

    }

    return $result ? _json_encode($result) : null;

}



}