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
          <h1 class="mb-0"><?php echo $app->component->transaction->getTotalProfitToday(); ?></h1>
        </div>
        <small><?php echo translate("tr_606dca682eeb69e36a441d70f4fd13c2"); ?></small>
      </div>
      <div class="col-12 col-md-8" >
        <div id="weeklyReports" style="min-height: 210px;" ></div>
      </div>
    </div>
    <div class="border rounded p-3 mt-4">
      <div class="row">
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $app->component->transaction->getTotalTransactions(); ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_77f9b85e7d01590d032f2855362be8f7"); ?></p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $app->component->transaction->getTotalDeals(); ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_a2cd08bbbe3c1bea939897a780561a1c"); ?></p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0"><?php echo $app->component->transaction->getTotalProfit(); ?></h3>
          </div>
          <p class="mb-0"><?php echo translate("tr_2bc3e9d81aa0f877b2088a880ab5ed09"); ?></p>
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
          <h4 class="m-0 me-2"><?php echo translate("tr_100ceea2b3133b41012e7423ff263161"); ?> <?php echo $app->datetime->getCurrentNameMonth(); ?></h4>
        </div>
        <a class="btn btn-label-primary waves-effect" href="<?php echo $app->router->getRoute("dashboard-transactions-statistics"); ?>" >
          <?php echo translate("tr_dad6f81abe0d432860d0304b4c129ec2"); ?>
        </a>
      </div>
      <div class="card-body">
        <div id="monthReports" style="min-height: 210px;"></div>
      </div>
    </div>
</div>

</div>