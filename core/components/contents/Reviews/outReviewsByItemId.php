public function outReviewsByItemId($data=[]){
    global $app;

    $getReviews = $app->model->reviews->sort("id desc")->getAll("item_id=? and whom_user_id=? and parent_id=? and status=?", [$data->id,$data->user_id,0,1]);

    if($getReviews){

        foreach ($getReviews as $key => $value) {

            $from_user = $app->model->users->findById($value["from_user_id"]);
            $parent_reviews = $app->model->reviews->sort("id asc")->getAll("item_id=? and parent_id=?", [$data->id,$value["id"]]);

            ?>

            <div class="container-reviews-list-item" >
              
               <div class="container-reviews-list-item-info" >
                  <div class="container-reviews-list-item-info-block1" > <div class="container-reviews-list-item-info-avatar" ><img class="image-autofocus" src="<?php echo $app->storage->name($from_user->avatar)->host(true)->get(); ?>"></div> </div>
                  <div class="container-reviews-list-item-info-block2" >
                     <span class="container-reviews-list-item-info-name" ><?php echo $app->user->name($from_user,true); ?></span>
                     <span class="container-reviews-list-item-info-date" ><?php echo $app->datetime->outDate($value["time_create"]); ?></span>
                  </div>
                  <div class="container-reviews-list-item-info-block3" >

                    <div class="container-user-rating-stars menu-user-rating-stars" >
                        <?php echo $app->component->profile->outStarsRating($value["rating"]); ?>
                    </div>

                  </div>
               </div>

               <div class="container-reviews-list-item-text" >
                  <?php echo $value["text"]; ?>
               </div>

               <?php echo $this->outMedia($value["media"]); ?>

               <?php if($data->owner){ ?>
               <span class="btn-custom-mini button-color-scheme1 mt10 actionOpenStaticModal" data-modal-target="responseReview" data-modal-params="<?php echo buildAttributeParams(["id"=>$value["id"], "name"=>$app->user->name($from_user,true)]); ?>" ><?php echo translate("tr_e5681e2700570729e8d3a3bf4efa2d5c"); ?></span>
               <?php } ?>
               
               <?php
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
               ?>

            </div>                

            <?php
        }


    }

}