public function outParentMessages($id=0){
    global $app;

    $parent_reviews = $app->model->reviews->sort("id asc")->getAll("parent_id=?", [$id]);

    if($parent_reviews){

        foreach ($parent_reviews as $parent_value) {

            $from_user = $app->model->users->findById($parent_value["from_user_id"]);

            ?>

              <div class="container-reviews-list-item container-reviews-list-item-parent" >
                
                 <div class="container-reviews-list-item-info" >
                    <div class="container-reviews-list-item-info-block1" > <div class="container-reviews-list-item-info-avatar" ><img class="image-autofocus" src="<?php echo $app->storage->name($from_user->avatar)->host(true)->get(); ?>"></div> </div>
                    <div class="container-reviews-list-item-info-block2" >
                       <span class="container-reviews-list-item-info-name" ><?php echo $app->user->name($from_user,true); ?></span>
                       <span class="container-reviews-list-item-info-date" ><?php echo $app->datetime->outDate($parent_value["time_create"]); ?></span>
                    </div>
                 </div>

                 <div class="container-reviews-list-item-text" >
                  <?php echo $parent_value["text"]; ?>
                 </div>

                 <?php if($parent_value["from_user_id"] == $app->user->data->id){ ?>
                 <span class="btn-custom-mini button-color-scheme6 mt10 actionDeleteReview" data-id="<?php echo $parent_value["id"]; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span>
                <?php } ?>
                
              </div>

            <?php
        }

    }

}