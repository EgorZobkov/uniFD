public function outAuthServices($button=false){
    global $app;

    if($app->settings->auth_services_list){
        $list = $app->model->system_oauth_services->getAll("id IN(".implode(",", $app->settings->auth_services_list).")");
        if($list){
            foreach ($list as $key => $value) {

                $instance = $app->addons->oauth($value["alias"]);

                if(!$button){
                    echo '<a href="'.$instance->buildLink().'" ><img src="'.$instance->logo().'" title="'.$value["name"].'"></a>';
                }else{
                    echo '<a class="btn-custom button-color-scheme2 button-color-'.$value["alias"].' width100" href="'.$instance->buildLink().'" >'.$value["name"].'</a>';
                }

            }
        }
    }

}