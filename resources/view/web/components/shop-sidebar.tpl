<div class="profile-user-sidebar" >

  <div class="profile-user-sidebar-row" >
      <div class="profile-user-sidebar-col-1" >
          <?php echo $app->component->profile->outAvatarStories($data->shop->image, $data->user->id); ?>
      </div>

      <div class="profile-user-sidebar-col-2" >

          <a class="profile-user-sidebar-full-name" href="<?php echo $app->component->shop->linkToShopCard($data->shop->alias); ?>" ><?php echo $data->shop->title; ?> <?php echo $app->component->profile->verificationLabel($data->user->verification_status); ?></a>

          <div class="container-user-rating-stars menu-user-rating-stars" >
              <?php echo $app->component->profile->outStarsRating($data->user->total_rating); ?>
              <span class="user-rating-stars-count-reviews" ><?php echo  $app->component->profile->outTotalReviews($data->user->total_reviews); ?></span>
          </div> 

      </div>
  </div>

  <div class="d-none d-lg-block" >
  <?php if(!$data->owner){ ?>

  <button class="btn-custom button-color-scheme1 width100 mt10 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['whom_user_id'=>$data->user->id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>
 
  <?php if($app->component->profile->isSubscription($app->user->data->id, $data->user->id)){ ?>
    <button class="btn-custom button-color-scheme2 width100 mt10 actionSubscribeUser" data-id="<?php echo $data->user->id; ?>" ><?php echo translate("tr_d2023e4c921d1cc5865f230480442d3c"); ?></button>
  <?php }else{ ?>
    <button class="btn-custom button-color-scheme2 width100 mt10 actionSubscribeUser" data-id="<?php echo $data->user->id; ?>" ><?php echo translate("tr_3b1913989f1a538261b8abf5ffc88d4b"); ?></button>
  <?php } ?>  

  <?php } ?>

  </div>

  <?php if($app->user->isAuth() && !$data->owner){ ?>
  <div class="uni-dropdown mt10">
      <button class="btn-custom button-color-scheme2 width100 action-open-uni-dropdown"><?php echo translate("tr_ceac57c52ec2d76a3ccdc3df4dfdab6f"); ?> <i class="ti ti-chevron-down"></i></button>  
      <div class="uni-dropdown-content uni-dropdown-content-stretch uni-dropdown-content-top-50">
         <span class="uni-dropdown-content-item actionOpenStaticModal" data-modal-target="userComplain" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->user->id]); ?>" ><?php echo translate("tr_a7d9ae0c14b6559b102994d3f798a934"); ?></span>
         <?php if($app->component->profile->isBlacklist($app->user->data->id, $data->user->id)){ ?>
         <span class="uni-dropdown-content-item actionAddUserToBlacklist" data-id="<?php echo $data->user->id; ?>" ><?php echo translate("tr_e3d48147853bb99996169256b5eb7cb9"); ?></span>
         <?php }else{ ?>
         <span class="uni-dropdown-content-item actionAddUserToBlacklist" data-id="<?php echo $data->user->id; ?>" ><?php echo translate("tr_35903deefce1704c3623df8a08d9880f"); ?></span>
         <?php } ?>
      </div>               
  </div>
  <?php } ?>

</div>