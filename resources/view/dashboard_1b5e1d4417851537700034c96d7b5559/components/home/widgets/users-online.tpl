<?php
$totalAdministrators = $app->component->users->getTotalUsersOnline('administrators');
$totalUsers = $app->component->users->getTotalUsersOnline('users');
?>
<div class="<?php echo $widget->size_cell; ?> mb-4 home-widget-item" data-id="<?php echo $data->id; ?>" >
  <div class="card h-100">
    <div class="card-body">

      <div class="card-title header-elements">
        <h5 class="m-0 me-2"><?php echo translateField($widget->name); ?></h5>
        <div class="card-title-elements ms-auto">
          <span class="widget-sortable-handle" ><i class="tf-icons ti ti-arrows-maximize ti-sm text-muted"></i></span>
          <div class="dropdown">
            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ti ti-dots-vertical ti-sm text-muted"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" >
              <span class="dropdown-item cursor-pointer home-widget-item-remove" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_1705d7cb70e0c9d8820e1b03eca70f91"); ?></span>
            </div>
          </div>
        </div>
      </div>

      <div class="row gy-3 mt-3">

        <div class="col-md-6 col-6">
          <div class="d-flex align-items-center">
            <div class="badge rounded-pill bg-label-primary me-3 p-2">
              <i class="ti ti-users ti-sm"></i>
            </div>
            <div class="card-info">
              <h5 class="mb-0"><?php echo $totalUsers; ?></h5>
              <small><?php echo endingWord($totalUsers, translate("tr_1075de897df42cd76107c5e32827ef92"), translate("tr_10837c2e8c09a894e000ed95430024dc"), translate("tr_11e586d97e9b7fc95413e27878a89692")); ?></small>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-6">
          <div class="d-flex align-items-center">
            <div class="badge rounded-pill bg-label-danger me-3 p-2">
              <i class="ti ti-users ti-sm"></i>
            </div>
            <div class="card-info">
              <h5 class="mb-0"><?php echo $totalAdministrators; ?></h5>
              <small><?php echo endingWord($totalAdministrators, translate("tr_e79b378fa4c3efa2993f19538dbe472b"), translate("tr_79882bd2ca424c65a0d8ede77cb31969"), translate("tr_5f41dbd86e4cca80bde03a894d67cc37")); ?></small>
            </div>
          </div>
        </div>
      
      </div>

      <div class="pt-1">

      <div class="d-flex align-items-center avatar-group my-3">
        <?php
          $getUsers = $app->component->users->getListUsersOnline(10);
          if($getUsers){
            foreach ($getUsers as $key => $value) {
              ?>

                <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$value['id']]); ?>">
                  <div class="avatar" title="<?php echo $app->user->name($value,true); ?>" >
                    <img src="<?php echo $app->storage->name($value['avatar'])->get(); ?>" class="rounded-circle">
                  </div>
                </a>

              <?php
            }
          }
        ?>
      </div>

      <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo $app->router->getRoute("dashboard-users"); ?>?filter[online]=1" ><?php echo translate("tr_ae87273680051c7206be82680cd2a162"); ?></a>

      </div>
    </div>
  </div>
</div>