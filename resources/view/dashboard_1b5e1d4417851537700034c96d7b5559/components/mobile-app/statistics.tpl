<?php

$data = $app->api->getStat();

?>
<div class="row" >

<div class="col-lg-6 col-12 mb-4">
<div class="card" style="min-height: 430px;" >
  <div class="card-header d-flex align-items-center justify-content-between">
    <div class="card-title mb-0">
      <h4 class="mb-0"><?php echo translate("tr_8ae13832b62d790dac88d04bbf642044"); ?></h4>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-12 col-md-4 d-flex flex-column align-self-end">
        <div class="d-flex gap-2 align-items-center mb-0 pb-0 flex-wrap">
          <h1 class="mb-0"><?php echo $data->today_install; ?></h1>
        </div>
        <small><?php echo translate("tr_2de2e2f2bb09af627c417a3bd261763e"); ?></small>
      </div>
      <div class="col-12 col-md-8" >
        <div id="weeklyMobileAppStatReports" style="min-height: 210px;" ></div>
      </div>
    </div>
    <div class="border rounded p-3 mt-4">
      <div class="row">
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $data->total_install; ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_48013cdd5314bfd9aa5be12b8315b519"); ?></p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $data->active_sessions; ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_07e91169ce477ab956d5ee2bb0a7bfc2"); ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="col-lg-6 col-12 mb-4">
    <div class="card" style="min-height: 430px;">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h4 class="m-0 me-2"><?php echo translate("tr_f33dd5f0837b42471009768f9caa4aa6"); ?> <?php echo $app->datetime->getCurrentNameMonth(); ?></h4>
        </div>
      </div>
      <div class="card-body">
        <div id="monthMobileAppStatReports" style="min-height: 210px;"></div>
      </div>
    </div>
</div>

</div>