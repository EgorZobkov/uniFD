 public function outReviewsWhomUser($value){
     global $app;

     ?>

        <div class="container-reviews-list-item-info" >
           <div class="container-reviews-list-item-info-block1" > <div class="container-reviews-list-item-info-avatar" ><img class="image-autofocus" src="<?php echo $app->storage->name($value->whom_user->avatar)->host(true)->get(); ?>"></div> </div>
           <div class="container-reviews-list-item-info-block2" >
              <span class="container-reviews-list-item-info-name" >
                 <?php if($value->status == 0){ ?>
                 <div>
                   <span class="status-label status-label-color-warning"><?php echo translate("tr_d9d74d385363cf3fdf9c1e62b484acca"); ?></span>
                 </div>  
                 <?php } ?>              
                 <?php echo $app->user->name($value->whom_user,true); ?> <span class="container-reviews-list-item-info-name-and-date" ><?php echo $app->datetime->outDate($value->time_create); ?></span> 
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

        <?php if($value->from_user->id == $app->user->data->id){ ?>
        <span class="btn-custom-mini button-color-scheme6 mt10 actionDeleteReview" data-id="<?php echo $value->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span>
        <?php } ?>
        
        <?php echo $this->outParentMessages($value->id); ?>

     <?php

 }