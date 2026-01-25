public function outActiveServicesInCardAd($data){
    global $app;

    if($data->user_id == $app->user->data->id && $data->status == 1){

        $getActiveServices = $app->component->ad_paid_services->getActiveServicesByAd($data->id);

        if(!$getActiveServices->ids){
            if($app->settings->paid_services_status){
                ?>

                <div class="card-status-info card-status-info-bg-success mt15" >
                  <div>
                    <strong><?php echo translate("tr_876a40d4c0609bb10617c97694ab345f"); ?></strong>
                  </div>
                  <a class="btn-custom button-color-scheme1 mt15" href="<?php echo outRoute('ad-services', [$data->id]); ?>" ><?php echo translate("tr_091a6185400057872fc532948628a66c"); ?></a>
                </div>

                <?php
            }
        }else{
            ?>

            <div class="card-status-info card-status-info-bg-success mt15" >
              <div>
                <strong><?php echo translate("tr_b7295ff9007af02510daf883df396618"); ?></strong>

                <div class="ad-card-active-services-container" >
                <?php

                    foreach ($getActiveServices->data as $value) {

                        $progress = ((time() - strtotime($value->order->time_create)) / (strtotime($value->order->time_expiration) - strtotime($value->order->time_create))) * 100;

                        ?>
                        <div class="ad-card-active-services-item" >
                            <div class="ad-card-active-services-item-name" ><?php echo translateFieldReplace($value->service, "name"); ?></div>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>   
                        </div>                         
                        <?php
                    }

                ?>
                </div>

              </div>

              <?php if($app->settings->paid_services_status){ ?>

              <a class="btn-custom button-color-scheme1 mt15" href="<?php echo outRoute('ad-services', [$data->id]); ?>" ><?php echo translate("tr_091a6185400057872fc532948628a66c"); ?></a>

              <?php } ?>

            </div>

            <?php
        }

    }

}