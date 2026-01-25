public function outAvatarStories($image=null, $user_id=0){
    global $app;

    $getStory = $app->model->stories_media->sort("time_create desc")->find("user_id=? and status=?", [$user_id, 1]);

    if($getStory){
    ?>

      <div>
        <div class="user-avatar-by-stories actionOpenModalUserStories" data-id="<?php echo $user_id; ?>" >
            <div class="<?php if(!$app->component->stories->checkViewStories($getStory->id, $app->user->data->id)){ ?>stories-border-no-view<?php } ?>" >
                <div class="user-avatar-by-stories-circle" >
                    <img class="image-autofocus" src="<?php echo $app->storage->name($image)->get(); ?>">
                </div>
            </div>
        </div>
      </div>

    <?php
    }else{
    ?>

      <div>
          <div class="user-avatar-by-stories" >
            <div>
                <div class="user-avatar-by-stories-circle" >
                    <img class="image-autofocus" src="<?php echo $app->storage->name($image)->get(); ?>">
                </div>
            </div>
          </div>
      </div>

    <?php            
    }

}