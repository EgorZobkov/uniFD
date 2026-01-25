public function replaceDefaultData($text=null){
    global $app;

    $result = [];

    if($text){

        $macrosList = [
            "{domain}"=>getHost(false),
            "{domain_link}"=>getHost(),
            "{project_name}"=>$app->settings->project_name,
            "{project_title}"=>$app->settings->project_title,
            "{contact_email}"=>$app->settings->contact_email,
            "{contact_phone}"=>$app->settings->contact_phone,
            "{contact_organization_name}"=>$app->settings->contact_organization_name,
            "{contact_organization_address}"=>$app->settings->contact_organization_address,
            "{current_geo_name}" => $app->component->geo->getCurrentGeoBySeo()->name,
            "{current_geo_name_declension}" => $app->component->geo->getCurrentGeoBySeo()->name_declension,
            "{current_geo_text}" => nl2br($app->component->geo->getCurrentGeoBySeo()->seo_text),
        ];

        foreach ($macrosList as $key2 => $value2) {
            $text = str_replace($key2, $value2, $text);
        }

    }

    return $text;

}