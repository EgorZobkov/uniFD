public function checkAccessSite(){
    global $app;

    if(!$app->settings->access_status){

        $ips = [];

        if($app->settings->access_allowed_ip){
          $allowed_ip = explode(",",$app->settings->access_allowed_ip);
          foreach ($allowed_ip as $key => $value) {
            $ips[] = trim($value);
          }
        }

        if(!in_array(getIp(), $ips)){
        
            if($app->settings->access_action == "text"){

               abort(403, ["text"=>$app->settings->access_text, "title"=>translate("tr_5e0fdf78a87ddb64c9c72d11c779a494")]);

            }elseif($app->settings->access_action == "redirect"){

               if($app->settings->access_redirect_link) $app->router->goToUrl($app->settings->access_redirect_link);

            }

        }

    }

}