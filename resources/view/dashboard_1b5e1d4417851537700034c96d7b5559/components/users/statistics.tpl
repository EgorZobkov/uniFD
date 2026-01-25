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
          <h1 class="mb-0"><?php echo $app->component->users->getTotalUsersToday(); ?></h1>
        </div>
        <small><?php echo translate("tr_2686bc1594db25a3d5f4ca1ec3e5460b"); ?></small>
      </div>
      <div class="col-12 col-md-8" >
        <div id="weeklyUsersReports" style="min-height: 210px;" ></div>
      </div>
    </div>
    <div class="border rounded p-3 mt-4">
      <div class="row">
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $app->component->users->getTotalUsers(); ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_a00ecc5d266c29e56cfff153baf29302"); ?></p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $app->component->users->getTotalUsersActive(); ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_424b82cc36184bb66b1a83ba77d5d0bd"); ?></p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $app->component->users->getTotalUsersBlocked(); ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_aa7da6b6b0f9d367c8cd514ae6a19ead"); ?></p>
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
          <h4 class="m-0 me-2"><?php echo translate("tr_7a0284070e8afeb583a208a449cf4513"); ?> <?php echo $app->datetime->getCurrentNameMonth(); ?></h4>
        </div>
      </div>
      <div class="card-body">
        <div id="monthUsersReports" style="min-height: 210px;"></div>
      </div>
    </div>
</div>

</div>