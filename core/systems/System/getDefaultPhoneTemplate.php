public function getDefaultPhoneTemplate(){
    global $app;

    $template = (array)$app->config->phone_codes;

    if($app->settings->default_template_phone_iso){
        return $template[$app->settings->default_template_phone_iso];
    }else{
        return $template["RU"];
    }

    return [];

}