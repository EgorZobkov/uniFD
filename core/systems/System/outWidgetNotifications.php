public function outWidgetNotifications(){
    global $app;

    $apiNotifications = [];

    ob_start();

    if($app->settings->uni_api_last_notifications){
        foreach ($app->settings->uni_api_last_notifications as $value) {
            ?>

            <div class="card-widget-slider-item swiper-slide" >
              <h2 class="text-white mb-0 mt-0"> <strong><?php echo $value["title"]; ?></strong> </h2>

              <p class="text-white mb-0 mt-1" ><?php echo $value["text"]; ?></p>

              <?php if($value["button"]){ ?>
              <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo $value["button"]["link"]; ?>" ><?php echo $value["button"]["name"]; ?></a>
              <?php } ?>

            </div>

            <?php
        }
    }

    if(!$app->settings->crontab_time_last_execution){
        ?>
        <div class="card-widget-slider-item swiper-slide" >
          <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_64b6d889b9cfacde402506be7bc06bf2"); ?></strong> </h2>

          <p class="text-white mb-0 mt-1" ><?php echo translate("tr_4faaa1080cbf3cc29dcedd764e0b16fb"); ?></p>

          <button class="btn btn-label-primary waves-effect mt-3 openModal" data-modal-id="widgetNotificationCronModal" ><?php echo translate("tr_41c72714bbc27f600124f8e97727e17b"); ?></button>

        </div>            
        <?php
    }else{

        if($app->datetime->getTime($app->settings->crontab_time_last_execution) + 300 < $app->datetime->currentTime()){
            ?>
            <div class="card-widget-slider-item swiper-slide" >
              <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_64b6d889b9cfacde402506be7bc06bf2"); ?></strong> </h2>

              <p class="text-white mb-0 mt-1" ><?php echo translate("tr_96f53b7985f152e753ddfcb63317b4be"); ?></p>

              <button class="btn btn-label-primary waves-effect mt-3 openModal" data-modal-id="widgetNotificationCronModal" ><?php echo translate("tr_41c72714bbc27f600124f8e97727e17b"); ?></button>

            </div>            
            <?php                
        }

    }

    if(!$app->settings->mailer_service){
        ?>
        <div class="card-widget-slider-item swiper-slide" >
          <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_b39f4099540dd5eb2c0d13e6ed40fde1"); ?></strong> </h2>

          <p class="text-white mb-0 mt-1" ><?php echo translate("tr_dfb918b903b1ae6b5195155de9fb8cd3"); ?></p>

          <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo getUrlDashboard().'/settings/mailing'; ?>" ><?php echo translate("tr_b1c0497af1a1c0e82e6926735e05ba86"); ?></a>

        </div>
        <?php
    }

    if(!$app->settings->integration_payment_services_active){
        ?>
        <div class="card-widget-slider-item swiper-slide" >
          <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_06af7dd185e713d01d1ec6fe109f6024"); ?></strong> </h2>

          <p class="text-white mb-0 mt-1" ><?php echo translate("tr_7e86b776f84aa82ef517b5bcf9c36b1b"); ?></p>

          <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo getUrlDashboard().'/settings/integrations'; ?>" ><?php echo translate("tr_b1c0497af1a1c0e82e6926735e05ba86"); ?></a>

        </div>
        <?php
    }

    if(!$app->settings->seo_robots_data){
        ?>
        <div class="card-widget-slider-item swiper-slide" >
          <h2 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_ab95ecb1ed8827ab92a06afe5a20191a"); ?></strong> </h2>

          <p class="text-white mb-0 mt-1" ><?php echo translate("tr_cde6c9ac0938af397cf29455d828fccb"); ?></p>

          <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo getUrlDashboard().'/settings/seo'; ?>" ><?php echo translate("tr_b1c0497af1a1c0e82e6926735e05ba86"); ?></a>

        </div>
        <?php
    }

    return ob_get_clean();

}