public function outOAuthServicesOptions(){
    global $app;

    $data = $app->model->system_oauth_services->sort("id desc")->getAll();

    if($data){
        foreach ($data as $key => $value) {
          ?>
          <option value="<?php echo $value["id"]; ?>" <?php if(compareValues($app->settings->auth_services_list, $value["id"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
          <?php
        }
    }

}