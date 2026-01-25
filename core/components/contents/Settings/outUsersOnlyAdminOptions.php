public function outUsersOnlyAdminOptions(){
    global $app;

    $data = $app->model->users->sort("id desc")->getAll("admin=?", [1]);

    if($data){
        foreach ($data as $key => $value) {
          ?>
          <option value="<?php echo $value["id"]; ?>" <?php if(compareValues($app->settings->system_report_recipients_ids, $value["id"])){ echo 'selected=""'; } ?> ><?php echo $app->user->name($value); ?></option>
          <?php
        }
    }

}