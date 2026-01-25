 public function outReviewsFromUser($value, $response=true){
     global $app;

     ?>

        <div class="container-reviews-list-item-info" >
           <div class="container-reviews-list-item-info-block1" > <div class="container-reviews-list-item-info-avatar" ><img class="image-autofocus" src="<?php echo $app->storage->name($value->from_user->avatar)->host(true)->get(); ?>"></div> </div>
           <div class="container-reviews-list-item-info-block2" >
              <span class="container-reviews-list-item-info-name" >             
                 <?php echo $app->user->name($value->from_user,true); ?> <span class="container-reviews-list-item-info-name-and-date" ><?php echo $app->datetime->outDate($value->time_create); ?></span> 
             </span>
              <span class="container-reviews-list-item-info-title" ><?php echo $value->item->title; ?></span>
           </div>
           <div class="container-reviews-list-item-info-block3" >

             <div class="container-user-rating-stars menu-user-rating-stars" >
                 <?php echo $app->component->profile->outStarsRating($value->rating); ?>
             </div>

           </div>
        </div>

        <div class="container-reviews-list-item-text" >
           <?php echo $value->text; ?>
        </div>

        <?php echo $this->outMedia($value->media); ?>

        <?php if($response){ ?>

        <?php if($value->whom_user->id == $app->user->data->id){ ?>
        <span class="btn-custom-mini button-color-scheme1 mt10 actionOpenStaticModal" data-modal-target="responseReview" data-modal-params="<?php echo buildAttributeParams(["id"=>$value->id, "name"=>$app->user->name($value->from_user,true)]); ?>" ><?php echo translate("tr_e5681e2700570729e8d3a3bf4efa2d5c"); ?></span>
        <?php } ?>
        
        <?php echo $this->outParentMessages($value->id); ?>

        <?php } ?>

     <?php

 }