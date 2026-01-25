<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_7f2bc39d518bee33f123f0b2c4042463"); ?></h2>
</div>

<div class="btn-group-horizontal text-md-center">

  <?php if($data->status == 0){ ?>
    <button type="button" class="btn btn-outline-primary buttonConfirmComplaint" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_4fe641d2daed23a32a61189bac0f2303"); ?></button>
    <button class="btn btn-outline-danger deleteComplaint" data-id="<?php echo $data->id; ?>" ><i class="ti ti-trash"></i></button>
  <?php } ?>

</div>

<div class="row g-3 mt-2" >
  
  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_dad1e0464c8958be0e18482bcadca6f5"); ?></label></strong>
    <div> <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$data->from_user->id]); ?>"><?php echo $data->from_user->name; ?></a> </div>
  </div>

  <?php if($data->ad){ ?>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d"); ?></label></strong>
    <div> <a href="#" class="loadAdCard" data-ad-id="<?php echo $data->ad->id; ?>" ><?php echo $data->ad->title; ?></a> </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_89c6aa402a6943e125af41880ed54a53"); ?></label></strong>
    <div> <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$data->whom_user->id]); ?>"><?php echo $data->whom_user->name; ?></a> </div>
  </div>

  <?php }else{ ?>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_1903adcc4cab4c91f84682a53c033dfc"); ?></label></strong>
    <div> <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$data->whom_user->id]); ?>"><?php echo $data->whom_user->name; ?></a> </div>
  </div>

  <?php } ?>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></label></strong>
    <div><?php echo $data->text; ?></div>
  </div>

</div>
