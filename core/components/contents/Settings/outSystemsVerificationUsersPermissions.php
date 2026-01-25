public function outSystemsVerificationUsersPermissions(){
    global $app;

    $result = $app->model->system_verification_users_permissions->getAll();
    if($result){
        foreach ($result as $key => $value) {
            if(compareValues($app->settings->verification_users_permissions,$value["code"])){
                echo '<option value="'.$value["code"].'" selected="" >'.translateField($value["name"]).'</option>';
            }else{
                echo '<option value="'.$value["code"].'" >'.translateField($value["name"]).'</option>';
            }
        }
    }

}