public function outDeliveryServicesOptions(){
    global $app;

    $data = $app->model->system_delivery_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>
          <option value="<?php echo $value["id"]; ?>" <?php if(compareValues($app->settings->integration_delivery_services_active, $value["id"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
          <?php
        }
    }

}