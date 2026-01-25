<div class="col-md-6 col-12 col-sm-6 col-lg-3" >
  <div class="profile-container-user-grid" >

    <div class="profile-container-user-grid-avatar" >
        <div class="profile-container-user-grid-avatar-circle" >
          <img src="<?php echo $app->storage->name($user->avatar)->get(); ?>" class="image-autofocus" >
        </div>
    </div>

    <a class="profile-container-user-grid-name" href="<?php echo outRoute("user-card", [$user->alias]); ?>"><?php echo $app->user->name($user); ?></a>

  </div>
</div>