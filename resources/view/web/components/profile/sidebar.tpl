<div class="profile-user-sidebar d-none d-lg-block" >

    <div class="profile-user-sidebar-avatar" >
      <div>
        <div class="profile-user-sidebar-avatar-change actionChangeUserAvatar" ><i class="ti ti-camera-selfie"></i></div>
        <img class="image-autofocus" src="<?php echo $app->user->data->avatar_src; ?>">
      </div>
    </div>

    <h4 class="profile-user-sidebar-full-name" ><?php echo $app->user->data->full_name; ?> <?php echo $app->component->profile->verificationLabel($app->user->data->verification_status); ?></h4>

    <div class="container-user-rating-stars menu-user-rating-stars" >
        <?php echo $app->component->profile->outStarsRating($app->user->data->total_rating); ?>
        <span class="user-rating-stars-count-reviews" ><?php echo $app->component->profile->outTotalReviews($app->user->data->total_reviews); ?></span>
    </div>

    <div class="profile-user-sidebar-menu" >

      <?php echo $app->component->profile->getMenu(); ?>

      <hr class="mt10 mb10" >

      <a href="<?php echo outRoute("profile-settings"); ?>"><i class="ti ti-settings"></i> <?php echo translate("tr_c919d65bd95698af8f15fa8133bf490d"); ?></a>
      <a href="<?php echo outRoute('profile-logout'); ?>"><i class="ti ti-logout"></i> <?php echo translate("tr_8ef2d61ae629c63b155ae66c3d2fc9fa"); ?></a>

    </div>

</div>