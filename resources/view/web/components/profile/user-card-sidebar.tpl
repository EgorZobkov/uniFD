<div class="profile-user-sidebar" >

  <?php echo $app->component->profile->outAvatarStories($data->user->avatar, $data->user->id); ?>

  <h4 class="profile-user-sidebar-full-name" ><?php echo $data->user->full_name; ?> <?php echo $app->component->profile->verificationLabel($data->user->verification_status); ?></h4>

  <div class="container-user-rating-stars menu-user-rating-stars" >
      <?php echo $app->component->profile->outStarsRating($data->user->total_rating); ?>
      <span class="user-rating-stars-count-reviews" ><?php echo $app->component->profile->outTotalReviews($data->user->total_reviews); ?></span>
  </div>

  <?php if(!empty($data->user->contacts->telegram)){ ?>
    <div class="profile-user-telegram mt10" >
      <a href="https://t.me/<?php echo $data->user->contacts->telegram; ?>" target="_blank" rel="noopener">
        <i class="ti ti-brand-telegram"></i>
        <span>@<?php echo $data->user->contacts->telegram; ?></span>
      </a>
    </div>
  <?php } ?>

  <button class="btn-custom button-color-scheme1 width100 mt30 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['whom_user_id'=>$data->user->id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>

  <?php if($app->component->profile->isSubscription($app->user->data->id, $data->user->id)){ ?>
    <button class="btn-custom button-color-scheme2 width100 mt10 actionSubscribeUser" data-id="<?php echo $data->user->id; ?>" ><?php echo translate("tr_d2023e4c921d1cc5865f230480442d3c"); ?></button>
  <?php }else{ ?>
    <button class="btn-custom button-color-scheme2 width100 mt10 actionSubscribeUser" data-id="<?php echo $data->user->id; ?>" ><?php echo translate("tr_3b1913989f1a538261b8abf5ffc88d4b"); ?></button>
  <?php } ?>

  <?php if($app->user->isAuth()){ ?>
  <div class="uni-dropdown">
      <button class="btn-custom button-color-scheme4 width100 action-open-uni-dropdown">Еще <i class="ti ti-chevron-down"></i></button>  
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