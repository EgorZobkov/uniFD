public function outMessengerServicesListEdit(){
    global $app;

    $data = $app->model->system_messenger_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>

            <span class="btn btn-outline-primary waves-effect settings-select-integration-messenger-load-edit" data-id="<?php echo $value["id"]; ?>">
              <img src="<?php echo $app->addons->messenger($value["alias"])->logo(); ?>" height="20" style="margin-right: 5px;" >
              <?php echo $value["name"]; ?>
            </span>

          <?php
        }
    }       

}