public function outDeliveryServicesListEdit(){
    global $app;

    $data = $app->model->system_delivery_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>

            <span class="btn btn-outline-primary waves-effect settings-select-integration-delivery-load-edit" data-id="<?php echo $value["id"]; ?>">
              <img src="<?php echo $app->addons->delivery($value["alias"])->logo(); ?>" height="20" style="margin-right: 5px;" >
              <?php echo $value["name"]; ?>
            </span>

          <?php
        }
    }       

}