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