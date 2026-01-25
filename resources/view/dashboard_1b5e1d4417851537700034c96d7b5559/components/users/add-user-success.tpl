<div class="mb-4 text-center">

  <img src="<?php echo $app->storage->getAssetImage('like-hand.webp'); ?>" height="128" />

  <h3 class="role-title mb-2 mt-3"> <strong><?php echo translate("tr_4cdb0e5903bbaf8ac72e4d3fbfc98680"); ?></strong> </h3>

</div>

<div class="alert alert-primary mb-4" role="alert">
  <div class="mb-1" ><?php echo translate("tr_4922ea013f76c2d3622baf1f607812b6"); ?> <strong><?php echo getUrlDashboard(); ?></strong> </div>
  <div class="mb-1" ><?php echo translate("tr_dee8dd43be7a62de96b9f30b9829ccf5"); ?> <strong class="user-login" ></strong> </div>
  <div><?php echo translate("tr_5ebe553e01799a927b1d045924bbd4fd"); ?> <strong class="user-pass" ></strong> </div>
</div>

<div class="text-center" >
  <button class="btn btn-primary waves-effect waves-light sendEmailAccessUser"><?php echo translate("tr_da548dacf4fdb0ae47b6b9c62bcb0635"); ?></button>
</div>