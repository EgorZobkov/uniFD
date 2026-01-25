public function multiPhonesStatus(){
    global $app;

    $result = [];
    $template = (array)$app->config->phone_codes;

    if(!$app->settings->allowed_templates_phone_all_status){
        if($app->settings->allowed_templates_phone){
            if(count($app->settings->allowed_templates_phone) == 1){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }else{
        return true;
    }

    return false;

}