public function outPaymentServicesListEdit(){
    global $app;

    $getAllPaymentServices = $this->getAllPaymentServices();

    if($getAllPaymentServices){
        foreach ($getAllPaymentServices as $key => $value) {
          ?>

            <span class="btn btn-outline-primary waves-effect settings-select-integration-payment-load-edit" data-id="<?php echo $value["id"]; ?>">
              <img src="<?php echo $app->addons->payment($value["alias"])->logo(); ?>" height="20" style="margin-right: 5px;" >
              <?php echo $value["name"]; ?>
            </span>

          <?php
        }
    }       

}