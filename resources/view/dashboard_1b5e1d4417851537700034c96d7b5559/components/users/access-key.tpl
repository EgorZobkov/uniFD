<div class="alert alert-primary d-flex align-items-center mb-2" role="alert">
  <span class="alert-icon text-primary me-2">
    <i class="ti ti-info-circle ti-xs"></i>
  </span>
  <?php echo translate("tr_4a6a6685b92aab997d6eea5c9cfd60c6"); ?>
</div>

<div class="row">

    <?php if($app->user->data->access_key->access_key){ ?>
    <div class="col-12 mb-3 mt-0">

      <label class="form-label mb-1" > <strong><?php echo translate("tr_401ced9ad2a26a575437113f5f793563"); ?></strong> </label>

      <div><?php echo getUrlDashboard(true).'/access-key/'.$app->user->data->access_key->access_key; ?></div>

    </div>

    <div class="col-12" >
      <button class="btn btn-label-success administatorGenerateAccessKey mt-2" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_a35d750dc0a7065b321072392db0c166"); ?></button>
      <button class="btn btn-label-danger administatorDeleteAccessKey mt-2" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
    </div>

    <?php }else{ ?>

      <div class="col-12" >
        <button class="btn btn-label-success administatorGenerateAccessKey mt-2" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_a35d750dc0a7065b321072392db0c166"); ?></button>
      </div>

    <?php } ?>

</div>