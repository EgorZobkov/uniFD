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