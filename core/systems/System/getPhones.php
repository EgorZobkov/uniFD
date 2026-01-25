public function getPhones(){
    global $app;

    $result = [];
    $template = (array)$app->config->phone_codes;

    if(!$app->settings->allowed_templates_phone_all_status){
        if($app->settings->allowed_templates_phone){
            foreach ($app->settings->allowed_templates_phone as $key => $value) {
                $result[$value] = $template[$value];
            }
        }else{
            return $template;
        }
    }else{
        return $template;
    }

    return $result;

}